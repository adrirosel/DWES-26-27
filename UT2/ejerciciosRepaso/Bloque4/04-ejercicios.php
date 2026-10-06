<?php

declare(strict_types=1);
require_once __DIR__ . '/../datos.php';

// 1. Escribe una función crearFiltroPrecioMinimo(float $min): callable 
//que devuelva una closure.

function crearFiltroPrecioMinimo(float $min): callable{
    return fn(array $p):bool => $p['precio'] > $min;
}

$masDe100 = crearFiltroPrecioMinimo(100);

$caros = array_filter($productos, $masDe100);

print_r($caros);

/*
2. Escribe filtrarPor(array $items, callable $criterio): array 
(tu propio array_filter con foreach). 
Así entiendes qué hace internamente un callback.
 */

function filtrarPor(array $items, callable $criterio): array {
    $resultado = [];
    foreach ($items as $clave => $item) {
        if ($criterio($item)) {
            $resultado[$clave] = $item;
        }
    }
    return $resultado;
}

/*
3. Reto: escribe tu propio miMap y miReduce con foreach. 
Si los entiendes por dentro, la sintaxis deja de ser magia.
 */

function miMap(callable $criterio, array $items): array{
    $itemsMapeados = [];
    foreach($items as $item){
        $itemsMapeados[] = $criterio($item);
        //Donde criterio es la acción que queremos aplicar a cada elemento del array original
        //Lo aplicamos sin distincion a todos los elementos, sin modificar la longitud del array anterior
    }
    return $itemsMapeados;
}

function miReduce(array $items, callable $callback, mixed $inicial = null): mixed {
    $carry = $inicial;
    foreach ($items as $item) {
        $carry = $callback($carry, $item);
    }
    return $carry;
}

