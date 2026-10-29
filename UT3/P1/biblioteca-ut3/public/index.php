<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../datos/libros.php';

use AdrianRosel\Biblioteca\Servicio\BibliotecaService;

$service = new BibliotecaService($libros);

$q = $_GET['q'] ?? '';
$genero = $_GET['genero'] ?? '';
$tipo = $_GET['tipo'] ?? '';

if(in_array('destacados', $_GET)){
    $soloDestacados = $_GET['destacados'];
}








require dirname(__DIR__) . '/vistas/catalogo.php';
