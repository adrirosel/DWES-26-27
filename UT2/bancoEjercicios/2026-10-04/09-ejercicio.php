<?php
/*
Dado un array asociativo titulo => ejemplares, usa array_find_key para obtener la clave del primer
libro con 0 ejemplares. Comprueba también qué devuelve cuando ningún valor cumple la condición
*/
declare(strict_types=1);

$libros = [
    "El Quijote" => 3,
    "1984" => 5,
    "Cien años de soledad" => 0,
    "Dune" => 2,
];
//Titulo con 0 ejemplares
$clave = array_find_key($libros, 
    fn (int $n):bool => $n === 0
);
echo $clave;
$ejemplo =  array_find_key($libros, 
     fn (int $n):bool => $n === 6
 );

echo $ejemplo;
//Cuando ningun valor cumple con la condicion, devuelve null