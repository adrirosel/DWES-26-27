<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../datos/libros.php';

use AdrianRosel\Biblioteca\Servicio\BibliotecaService;

$service = new BibliotecaService($libros);

$valores = [
    'tipo' => '',
    'titulo'=> '', 
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

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if($metodo === 'POST'){

    $camposTexto = ['tipo', 'titulo', 'autor', 'paginas', 'genero',
                    'unidades', 'fechaAlta', 'observaciones', 'correo'];
    foreach($camposTexto as $campo){
        $valorBruto = $_POST[$campo] ?? '';

        if(!is_string($valorBruto)){
            $errores[$campo] = "Se debe de introducir una cadena de texto en el campo $campo";
            $valores[$campo] = '';
        } else {
            $valores[$campo] = trim($valorBruto);
        }
    }
    $limites = ['titulo' => 120, 'autor' => 100, 'observaciones' => 300];
    foreach($limites as $campo => $max){
        if(isset($errores[$campo])){
            continue;
        } elseif(mb_strlen($limites[$campo], 'UTF-8') === 0){
            $errores[$campo] = 'Campo obligatorio';
        } elseif(mb_strlen($limites[$campo], 'UTF-8') > $max){
            $errores[$campo] = "Máximo $max caracteres.";
        }
    }
    $rangos = ['paginas' => [1, 3000], 'unidades' => [1, 50]];
    foreach($rangos as $rango => [$min, $max]){
        if(isset($errores[ $rango])){
            continue;
        }
        $numero = filter_var($valores[$rango], FILTER_VALIDATE_INT);
        if($numero === false){
            $errores[$rango] = 'Debe ser un número entero.';
        }elseif($numero < $min || $numero > $max){
            $errores[$rango] = "Debe estar entre $min y $max";
        }
        
    }
    if (!isset($errores['correo'])
        && filter_var($valores['correo'], FILTER_VALIDATE_EMAIL) === false) {
        $errores['correo'] = 'El correo no es válido.';
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
        if ($_POST['destacado'] === '1') {
            $valores['destacado'] = true;
        } else {
            $errores['destacado'] = 'Valor de destacado no válido.';
        }
    }
}


require dirname(__DIR__) . '/vistas/alta.php';