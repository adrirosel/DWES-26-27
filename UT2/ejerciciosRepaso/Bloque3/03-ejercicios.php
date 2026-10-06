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

echo '<br><br><br>';
// 3. El precio medio de los productos con stock

//Para sacar la media necesito:
// 1. La suma total de precios de los productos con stock
// 2. La cantidad de productos con stock

// Primero consigo los productos que tienen stock con array_filter

$productosConStock = array_values(array_filter($productos, fn(array $p):bool => $p['stock'] > 0));

print_r($productosConStock);

//Suma total de precios

$totalPrecios = array_reduce($productosConStock, fn(float $carry, array $p):float => $carry + $p['precio'], 0.0);

print_r($totalPrecios);

$media = $totalPrecios / count($productosConStock);
//Como todas las posiciones del array tienen stock, no hace falta usar array_reduce otra vez

echo '<br>';
print_r(round($media, 2));
echo '<br>';

// 4. Imprime por pantalla una línea tipo Portátil - 899.99 € por cada producto.
// ¿foreach o array_map? Hazlo con ambos y razona cuál es más natural aquí.

//Usando foreach

foreach($productos as $producto){
    echo $producto['nombre'] . ' - ' . $producto['precio'] . '€'. '<br>';
}

// Usando array_map

$lineas = array_map(
    fn(array $p):string => $p['nombre'] . ' - ' . $p['precio'] . ' €',
    $productos);
echo '<br>';
print_r($lineas);
//mi razonamiento es que para imprimir unicamente esa linea, 
//es mucho mas comodo un foreach concatenando propiedades

// 5. Recorre los productos y para en cuanto encuentres uno sin stock mostrando su nombre. 
//¿Qué herramienta es la correcta
// y por qué array_find o foreach con break sirven, pero array_filter no es la mejor?

$productoSinStock = array_find($productos, 
                            fn(array $p):bool => $p['stock'] === 0);

echo '<br>';
print_r($productoSinStock['nombre']);

//Array_find es la ideal, la funcion callback realiza el filtrado mediante la condicion
// y para inmediatamente cuando encuentra el primer valor que cumple con la condicion
//foreach con un break tambien es valido, pero se necesitan mas lineas de codigo
//por tanto, no es la mejor solucion

//En cambio, se descarta array_filter, este se encarga de devolver todos los elementos
//que encuentre que cumplan con la condicion, ya que recorre el array completo