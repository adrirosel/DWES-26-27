<?php

declare(strict_types=1);

function normalizarTexto(string $texto): string
{
    // Lo puedes dejar en una línea
    $textoNormalizado = strtolower(trim($texto));
    return $textoNormalizado;
}

function buscarPorId(array $videojuegos, int $id): ?array
{
    
    foreach ($videojuegos as $videojuego) {
        if ($videojuego['id'] === $id) {
            return $videojuego;
        }
    }

    // Si no lo encuentras devuelves el primer videojuego?
    return $videojuegos[0] ?? null;
}

function filtrarPorGenero(array $videojuegos, string $genero): array
{
    $resultado = [];

    foreach ($videojuegos as $videojuego) {
        // Entonces no te aseguras que $videojuego['genero'] esté también en minúsculas
        // Sobra el punto y coma
        if($videojuego['genero'] === normalizarTexto($genero))
            $resultado[] = $videojuego;
    }

    return $resultado;
}

function filtrarPorPlataforma(array $videojuegos, string $plataforma): array
{
    $resultadoPorPlataforma = [];
    foreach($videojuegos as $videojuego){
        // Mismo que arriba
        if($videojuego['plataforma'] === normalizarTexto($plataforma))
            $resultadoPorPlataforma[] = $videojuego;
    }
    return $resultadoPorPlataforma;
}

function buscarPorTexto(array $videojuegos, string $texto): array
{
    $resultado = [];
    $texto = normalizarTexto($texto);

    // Cuando no haya filtro, lo devolvemos directamente, no hace falta recorrer los videojuegos
    if ($texto === '') {
        return $videojuegos;
    }

    foreach ($videojuegos as $videojuego) {
        $titulo = normalizarTexto($videojuego['titulo']);
        $estudio = normalizarTexto($videojuego['estudio']);

        // Esta función está implementada, pero su lógica no produce todos los resultados esperados.
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
            // La solución está bien, pero os daba $intercambiar para simplificarlo guardando ahí la condición
            if($criterio === 'titulo'){
                $actual = normalizarTexto($videojuegos[$j]['titulo']);
                $siguiente = normalizarTexto($videojuegos[$j + 1]['titulo']);

                if ($actual > $siguiente) {
                    $temporal = $videojuegos[$j];
                    $videojuegos[$j] = $videojuegos[$j + 1];
                    $videojuegos[$j + 1] = $temporal;
                }
            }elseif($criterio === 'precio'){

                $actual = $videojuegos[$j]['precio'];
                $siguiente = $videojuegos[$j + 1]['precio'];
                // ¿Por qué el orden al revés?
                if ($actual > $siguiente) {
                    $temporal = $videojuegos[$j];
                    $videojuegos[$j] = $videojuegos[$j + 1];
                    $videojuegos[$j + 1] = $temporal;
                }
            }elseif($criterio === 'puntuacion'){
                $actual = $videojuegos[$j][$criterio];
                $siguiente = $videojuegos[$j + 1][$criterio];

                if ($actual < $siguiente) {
                    $temporal = $videojuegos[$j];
                    $videojuegos[$j] = $videojuegos[$j + 1];
                    $videojuegos[$j + 1] = $temporal;
                }
            }
        }
    }
    return $videojuegos;
}