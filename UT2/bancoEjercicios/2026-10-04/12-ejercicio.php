<?php
/*
A partir de una colección de libros, obtén primero un array solo con sus títulos. Después crea otro
array indexado por id que conserve el registro completo de cada libro usando array_column.
 */

require_once __DIR__ . '/../2026-10-01/datos.php';
$titulos = array_column(
    $libros, 
    'titulo'
);

$arrayIndexadoPorId = array_column(
    $libros, 
    null, 
    'id'
);

foreach($titulos as $titulo){
    echo $titulo . '<br>';
}
echo '<br><br>';
foreach ($arrayIndexadoPorId as $id => $libro) {
    echo "Libro con clave $id:<br>";
    foreach ($libro as $clave => $valor) {
        echo $clave . ', ' . $valor . '<br>';
    }
    echo '<br>';
}