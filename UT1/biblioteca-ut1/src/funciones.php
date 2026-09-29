<?php

declare(strict_types=1);

function buscarPorId(array $libros, int $id): ?array {
    foreach($libros as $libro){
        if($libro['id'] === $id){
            return $libro;
        }
    }
    return null;
}

function filtrarPorGenero(array $libros, string $genero): array{
    $librosFiltrados = [];
    foreach($libros as $libro){
        if(strtolower($libro['genero']) === $genero){
            $librosFiltrados[] = $libro;
        }
    }
    return $librosFiltrados;
}

function filtrarDisponibles(array $libros): array{
    $disponibles = [];
    foreach($libros as $libro){
        if($libro['disponible'] === true){
            $disponibles[] = $libro;
        }
    }
    return $disponibles;
}

function calcularMediaPaginas(array $libros): float{
    if(count($libros) === 0){
        return 0.00;
    }
    $totalPaginas = 0;
    foreach($libros as $libro){
        $totalPaginas += $libro['paginas'];
    }
    $media = $totalPaginas / count($libros);
    return $media;
    
}

function obtenerLibroMasLargo(array $libros): ?array{
    if(count($libros) === 0) return null;
    $libroMasLargo = $libros[0];
    foreach($libros as $libro){
        if($libro['paginas'] > $libroMasLargo['paginas']){
            $libroMasLargo = $libro;
        }
    }
    return $libroMasLargo;
}

function filtrarPorTexto(array $libros ,string $texto): ?array{
    if(count($libros) === 0) return null;
    $librosPorTexto = [];
    foreach($libros as $libro){
        if((strtolower($libro['titulo']) === $texto) || (strtolower($libro['autor']) === $texto)){
            $librosPorTexto[] = $libro;
        }
    }
    return $librosPorTexto;
}