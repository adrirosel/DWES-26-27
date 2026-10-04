<?php
/*
Elimina géneros repetidos mediante array_unique. Después construye un libro asociativo con
array_combine a partir de un array de claves y otro de valores. Indica qué requisito deben cumplir
ambos arrays.
*/
declare(strict_types=1);
require_once __DIR__ . '/../2026-10-01/datos.php';

$generos = array_column(
    $libros, 
    'genero'
);

$generosSinRepetidos = array_unique($generos);
foreach($generosSinRepetidos as $genero){
    echo $genero . '<br>';
}

$claves = ['id', 'titulo', 'autor', 'genero'];
$valores = [1, 'Cien años de Soledad', 'Gabriel García Márquez', 'realismo magico'];

$libro = array_combine($claves, $valores);
echo '<br>';
foreach($libro as $clave => $valor){
    echo $clave . ': ' . $valor . '<br>';
}

//Ambos arrays deben tener el mismo numero de posiciones para poder implementar el metodo array_combine()