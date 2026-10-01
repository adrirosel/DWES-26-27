<?php

declare(strict_types=1);
require_once __DIR__ . '/datos.php';

$libroBuscado = array_find(
    $libros, 
    fn (array $l):bool => $l['id'] === 3
);

if($libroBuscado !== null){
    echo $libroBuscado['titulo'];
} else{
    echo 'Libro no encontrado';
}