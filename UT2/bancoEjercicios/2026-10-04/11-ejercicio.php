<?php
// Busca 'terror' dentro de un array de géneros usando array_search con comparación estricta. Escribe la
// condición correcta para distinguir entre una clave 0 válida y el valor false de 'no encontrado'

declare(strict_types=1);

$generos = ['fantasia', 'terror', 'comedia', 'misterio'];

$generoBuscado = array_search(
    'drama', 
    $generos, 
    true
);

if($generoBuscado !== false){
    echo "Encontrado en la posicion $generoBuscado";
} else {
    echo 'No encontrado';
}