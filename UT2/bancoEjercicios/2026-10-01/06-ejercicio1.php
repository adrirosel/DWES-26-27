<?php

declare(strict_types=1);
require_once __DIR__ . '/datos.php';

$nuevo = array_map(
    fn(array $a): array => [
        ...$a,
        'descripcion' => $a['titulo'] . ' - ' . $a['paginas']
    ],
    $libros
);

$clave = array_search(
    'El principito', 
    array_column($libros, 'titulo'), 
    true
);

if($clave !== false){
    echo $clave;
}