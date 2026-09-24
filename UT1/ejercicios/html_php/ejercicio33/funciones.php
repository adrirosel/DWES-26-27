<?php
declare(strict_types=1);

function filtrarGenero(array $catalogo, string $genero): array{
    if($genero === 'todos') return $catalogo;

    $resultado = [];

    foreach($catalogo as $libro){
        if($libro['genero'] === $genero){
            $resultado[] = $libro;
        }
    }
    return $resultado;
}