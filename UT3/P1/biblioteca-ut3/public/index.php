<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../datos/libros.php';

use AdrianRosel\Biblioteca\Servicio\BibliotecaService;

$service = new BibliotecaService($libros);

$q = $_GET['q'] ?? '';
$genero = $_GET['genero'] ?? '';
$tipo = $_GET['tipo'] ?? '';

$soloDestacados = isset($_GET['destacados']);


$librosFiltrados = $service->filtrar($q, $genero, $tipo, $soloDestacados);

$filas = $service->filas($librosFiltrados);
$resumen = $service->resumen($librosFiltrados);






require dirname(__DIR__) . '/vistas/catalogo.php';
