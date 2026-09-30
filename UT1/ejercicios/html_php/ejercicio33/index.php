<?php

require_once __DIR__ . '/funciones.php';
require_once __DIR__ . '/datos.php';
date_default_timezone_set('Europe/Madrid');

$genero = $_GET['genero'] ?? 'todos';
$genero = strtolower(trim($genero));

//guardo el valor del filtrado en una variable
$respuesta = filtrarGenero($catalogo, $genero);

sort($respuesta);

echo '<h1>Ejercicio integrado</h1><br>';

echo 'Resultados: ' . count($respuesta) . '<br><br>';

$hoy = new DateTimeImmutable();
$fechaRevision = $hoy->modify('+30 days');

echo 'Fecha de revisión: ' . $fechaRevision->format('d/m/Y H:i');

//Llamo a la funcion que imprime los titulos del catalogo de libros
mostrarTitulos($catalogo);

?>

