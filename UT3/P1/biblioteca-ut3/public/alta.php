<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../datos/libros.php';

use AdrianRosel\Biblioteca\Modelo\LibroDigital;
use AdrianRosel\Biblioteca\Modelo\LibroPapel;
use AdrianRosel\Biblioteca\Servicio\BibliotecaService;


$service = new BibliotecaService($libros);

$valores = [
    'tipo' => '',
    'titulo' => '',
    'autor' => '',
    'paginas' => '',
    'genero' => '',
    'unidades' => '',
    'fechaAlta' => '',
    'destacado' => false,
    'observaciones' => '',
    'correo' => '',
];

$errores = [];
$ficha = null;
$filas = [];
$resumen = [
    'titulos' => 0,
    'unidades' => 0,
    'paginas' => 0,
    'costeCentimos' => 0,
];

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($metodo === 'POST') {
    $camposTexto = [
        'tipo', 'titulo', 'autor', 'paginas', 'genero',
        'unidades', 'fechaAlta', 'observaciones', 'correo',
    ];

    foreach ($camposTexto as $campo) {
        $valorBruto = $_POST[$campo] ?? '';

        if (!is_string($valorBruto)) {
            $errores[$campo] = "Se debe de introducir una cadena de texto en el campo $campo";
            $valores[$campo] = '';
        } else {
            $valores[$campo] = trim($valorBruto);
        }
    }

    $limites = ['titulo' => 120, 'autor' => 100, 'observaciones' => 300];
    foreach ($limites as $campo => $max) {
        if (isset($errores[$campo])) {
            continue;
        }
        if ($campo !== 'observaciones' && $valores[$campo] === '') {
            $errores[$campo] = 'Campo obligatorio';
        } elseif (mb_strlen($valores[$campo], 'UTF-8') > $max) {
            $errores[$campo] = "Máximo $max caracteres.";
        }
    }

    $rangos = ['paginas' => [1, 3000], 'unidades' => [1, 50]];
    foreach ($rangos as $campo => [$min, $max]) {
        if (isset($errores[$campo])) {
            continue;
        }
        $numero = filter_var($valores[$campo], FILTER_VALIDATE_INT);
        if ($numero === false) {
            $errores[$campo] = 'Debe ser un número entero.';
        } elseif ($numero < $min || $numero > $max) {
            $errores[$campo] = "Debe estar entre $min y $max";
        }
    }

    if (!isset($errores['correo'])) {
        if ($valores['correo'] === '') {
            $errores['correo'] = 'Campo obligatorio';
        } elseif (filter_var($valores['correo'], FILTER_VALIDATE_EMAIL) === false) {
            $errores['correo'] = 'El correo no es válido.';
        }
    }

    if (!isset($errores['tipo'])
        && !in_array($valores['tipo'], ['papel', 'digital'], true)) {
        $errores['tipo'] = 'Elige papel o digital.';
    }

    if (!isset($errores['genero'])
        && !in_array($valores['genero'], ['ciencia', 'fantasia', 'terror'], true)) {
        $errores['genero'] = 'Elige ciencia, fantasía o terror.';
    }

    $fecha = null;
    if (!isset($errores['fechaAlta']) && $valores['fechaAlta'] !== '') {
        try {
            $f = DateTimeImmutable::createFromFormat('!Y-m-d', $valores['fechaAlta']);
        } catch (ValueError) {
            $f = false;
        }
        if ($f === false || $f->format('Y-m-d') !== $valores['fechaAlta']) {
            $errores['fechaAlta'] = 'Usa el formato YYYY-MM-DD con una fecha real.';
        } else {
            $fecha = $f;
        }
    }

    if (array_key_exists('destacado', $_POST)) {
        if (is_string($_POST['destacado']) && $_POST['destacado'] === '1') {
            $valores['destacado'] = true;
        } else {
            $errores['destacado'] = 'Valor de destacado no válido.';
            $valores['destacado'] = false;
        }
    }

    if ($errores === []) {
        try {
            if ($valores['tipo'] === 'papel') {
                $libro = new LibroPapel(
                    $valores['titulo'],
                    $valores['autor'],
                    (int) $valores['paginas'],
                    $valores['genero'],
                    (int) $valores['unidades'],
                    $fecha,
                    $valores['destacado'],
                    $valores['observaciones']
                );
            } else {
                $libro = new LibroDigital(
                    $valores['titulo'],
                    $valores['autor'],
                    (int) $valores['paginas'],
                    $valores['genero'],
                    (int) $valores['unidades'],
                    $fecha,
                    $valores['destacado'],
                    $valores['observaciones']
                );
            }
            $service->agregar($libro);
            $ficha = $service->filas([$libro])[0];
            $filas = $service->filas($service->todos());
            $resumen = $service->resumen($service->todos());
        } catch (InvalidArgumentException $e) {
            $errores['general'] = $e->getMessage();
            $ficha = null;
        }
    }
}

require dirname(__DIR__) . '/vistas/alta.php';
