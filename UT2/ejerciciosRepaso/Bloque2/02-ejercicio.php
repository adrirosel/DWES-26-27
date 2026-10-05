<?php

declare(strict_types=1);
require_once __DIR__ . '/../datos.php';

//Un array solo con los nombres (haz una versión con array_column y otra con array_map)

//Usando array_column

$nombreProductos = array_column($productos, 'nombre');
//Me devuelve solo la columna de nombre
//print_r($nombreProductos);
//Usando array_map

$nombreProductosMap = array_map(
    fn(array $producto):string => $producto['nombre'],
    $productos
);
echo'<br>';
//print_r($nombreProductosMap);
//Esto devuelve unicamente los valores de la columna nombre

// Los productos sin stock, reindexados.

$productosSinStock = array_values(array_filter($productos,
                                fn(array $producto):bool => $producto['stock'] === 0));

//Va a devolver un array de productos reindexado, sin stock

//var_dump($productosSinStock);

// Los nombres de los productos de oficina, 
//en un solo bloque encadenando funciones.

$productosDeOficina = array_column(array_filter($productos,
                                fn(array $producto):bool => $producto['categoria'] === 'oficina'), 'nombre');
//Va a devolver un array de nombres de productos de oficina, solo los nombres

//print_r($productosDeOficina);

//Un array de precios con IVA del 21 % aplicado a cada producto 
//(que siga siendo un array de productos, no solo precios).

// $ivaAplicado = array_map(
//     fn(array $producto):float => $producto['precio'] * 0.21,
//     $productos
// );




$ivaAplicado = array_map(function(array $producto):array {
    round($producto['precio'] *= 1.21, 2);
    return $producto;
}, $productos);

//Va a salir el array productos completo con el precio actualizado con el IVA 
// foreach($ivaAplicado as $producto){
//     foreach($producto as $clave){
//         echo $clave . '<br>';
//     }
// }
print_r($ivaAplicado);

//El valor total del inventario (precio * stock de todos)
echo 'VERSION NUEVA <br>';
echo __FILE__ . '<br>';
$valorTotalInventario = array_reduce($productos,
                                    fn(float $carry, array $item):float =>
                                     $carry + ($item['precio'] * $item['stock']), 0.0);

//print_r($valorTotalInventario);
//Va a imprimir una variable de tipo float con el valor total de todo el inventario de productos 

//El primer producto con precio mayor de 100 (array_find) y 
//la clave del primer producto sin stock (array_find_key).

$primerPrecioMayorA100 = array_find($productos, 
                                    fn(array $p): bool => $p['precio'] > 100);

print_r($primerPrecioMayorA100); 
//Esto va a devolver el primer producto que encuentre que tenga el precio mayor a 100

$clavePrimerProductoSinStock = array_find_key($productos, 
                                                fn(array $p):bool =>$p['stock']=== 0);
echo '<br>';
//print_r($clavePrimerProductoSinStock);
//echo '<brZ';
//Esto va a devolver la clave del primer producto sin stock

// ¿Hay algún producto sin stock? ¿Todos cuestan más de 10 €? (array_any / array_all)

$productoSinStock = array_any($productos,
                            fn(array $p):bool => $p['stock']=== 0);
//La respuesta va a ser 1 (true)

// if(!$productoSinStock){
//     echo 'No hay ningun producto sin stock <br>';
// } else {
//     echo 'Se ha encontrado al menos 1 producto sin stock <br>';
// }

// $cuestanMasDe10 = array_all($productos, fn(array $p):bool => $p['precio'] > 10);

// if($cuestanMasDe10){
//     echo 'Todos los productos cuestan mas de 10 euros <br>';
// } else {
//     echo 'Hay productos que cuestan menos de 10 euros';
// }

//Las respuestas van a ser, el mensaje del else de la primera condicion y el primer mensaje de la segunda condicion

// Un array asociativo nombre => precio (array_column con tercer parámetro, y luego otra versión con array_combine).

$preciosProductos = array_column($productos, 'precio', 'nombre');

print_r($preciosProductos);
//Devuelve un array de precios, utilizando el tercer parametro para asignarle a cada precio (valor) su nombre (clave)

$preciosProductos2 = array_combine(array_column($productos, 'nombre'), array_column($productos, 'precio'));

//Usando array_combine y concatenando en cada argumento array_column, obtenemos el mismo resultado
echo '<br>';
print_r($preciosProductos2);

//Categorias sin repetir

$categoriasUnicas = array_values(array_unique(array_column($productos, 'categoria')));

//Va a devolver un array con las categorias sin repetir, usando array_column para extrar dicha columna

echo '<br>';
print_r($categoriasUnicas);