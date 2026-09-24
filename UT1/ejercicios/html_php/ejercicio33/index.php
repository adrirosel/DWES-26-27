<?php

require_once 'C:\DWES 26-27\UT1\ejercicios\html_php\ejercicio33|datos.php';
require_once __DIR__ . './funciones.php';

$genero = $_GET['genero'] ?? 'todos';
$genero = strtolower(trim($genero));

$respuesta = filtrarGenero($catalogo, $genero);

echo $catalogo[0]['titulo'];

