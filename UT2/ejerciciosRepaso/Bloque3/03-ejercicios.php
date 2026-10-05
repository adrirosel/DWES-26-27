<?php

declare(strict_types=1);
require_once __DIR__ . '/../datos.php';

// 1. Nombres de los productos de informática con stock, ordenados de más caro a más barato

$productosInformaticaConStock = array_filter($productos, fn(array $p):bool => $p['stock']>0 && $p['categoria'] === 'informática'); 

usort($productosInformaticaConStock, fn(array $a, array $b):int => $b['precio']<=> $a['precio']);

$nombresProductosInformaticaConStock = array_column($productosInformaticaConStock, 'nombre');

print_r($nombresProductosInformaticaConStock);

//Uso primero array_filter para filtrar por las condiciones requeridas
// Una vez he filtrado, hago la ordenacion segun el precio, de mayor a menor
// Por ultimo, saco un array unicamente con los nombres de los productos

echo '<br><br>';
                                
// 2. Un array que agrupe cuántos productos hay por categoría: ['informática' => 4, 'oficina' => 3]

$cantInformatica = array_reduce(
    $productos, 
    fn(int $carry, array $item):int => $item['categoria'] === 'informática' ? $carry + 1 : $carry, 
    0
);

$cantOficina = array_reduce(
    $productos, 
    fn(int $carry, array $item):int => $item['categoria'] === 'oficina' ? $carry + 1 : $carry, 
    0
);


$arrayResultante = array_combine(['informatica', 'oficina'], [$cantInformatica, $cantOficina]);

print_r($arrayResultante);