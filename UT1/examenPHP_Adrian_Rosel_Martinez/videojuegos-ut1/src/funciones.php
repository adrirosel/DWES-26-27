<?php

declare(strict_types=1);

function normalizarTexto(string $texto): string
{
    //Ahora en una linea
    return strtolower(trim($texto));
}

function buscarPorId(array $videojuegos, int $id): ?array
{
    foreach ($videojuegos as $videojuego) {
        if ($videojuego['id'] === $id) {
            return $videojuego;
        }
    }

    // Si no lo encuentra devuelve null (Corregido)
    return null;
}

function filtrarPorGenero(array $videojuegos, string $genero): array
{
    $resultado = [];

    foreach ($videojuegos as $videojuego) {
        //Normalizado, corregido
        if(strtolower(trim($videojuego['genero'])) === normalizarTexto($genero))
            $resultado[] = $videojuego;
        }

    return $resultado;
}

function filtrarPorPlataforma(array $videojuegos, string $plataforma): array
{
    $resultadoPorPlataforma = [];
    foreach($videojuegos as $videojuego){
        // Mismo que arriba
        if(strtolower(trim($videojuego['plataforma'])) === normalizarTexto($plataforma))
            $resultadoPorPlataforma[] = $videojuego;
    }
    return $resultadoPorPlataforma;
}

function buscarPorTexto(array $videojuegos, string $texto): array
{
    $resultado = [];
    $texto = normalizarTexto($texto);

    // // Como hago el filtrado en el index, aqui nunca llega
    // if ($texto === '') {
    //     return $videojuegos;
    // }

    foreach ($videojuegos as $videojuego) {
        $titulo = normalizarTexto($videojuego['titulo']);
        $estudio = normalizarTexto($videojuego['estudio']);
 
        if (str_contains($titulo, $texto) || str_contains($estudio, $texto)) {
            $resultado[] = $videojuego;
        }
    }

    return $resultado;
}

function ordenarVideojuegos(array $videojuegos, string $criterio): array
{
    $criterio = normalizarTexto($criterio);
    $cantidad = count($videojuegos);

    for ($i = 0; $i < $cantidad; $i++) {
        for ($j = 0; $j < $cantidad - 1; $j++) {
            //Corregido usando $intercambiar
            $actual = $videojuegos[$j];
            $siguiente = $videojuegos[$j + 1];

            $intercambiar = match($criterio){
                'precio' => $actual['precio'] > $siguiente['precio'],
                'puntuacion' => $actual['puntuacion'] > $siguiente['puntuacion'],
                default => $actual['titulo'] > $siguiente['titulo']
            };
            if($intercambiar){
                $temporal = $videojuegos[$j];
                $videojuegos[$j] = $videojuegos[$j + 1];
                $videojuegos[$j + 1] = $temporal;
            }
        }
    }
    return $videojuegos;
}