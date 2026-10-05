<?php

declare(strict_types=1);
// require_once __DIR__ . '/../datos.php';

$nums = [3, 8, 12, 5, 8, 20, 7, 3];

/*
Cada ejercicio, primero con foreach y luego con la función de array equivalente. 
Compara las dos versiones.
a) Los números mayores que 7.
b) Cada número al cuadrado.
c) La suma total.
*/

//a)
//Usando foreach
$mayoresQue7 = [];
foreach($nums as $n){
    if($n > 7){
        $mayoresQue7[] = $n;
    }
}
//Usando filter

$mayoresQue7v2 = array_filter($nums, fn(int $n): bool => $n > 7);
print_r(array_values($mayoresQue7v2));
//b)

//Usando foreach
$numsAlCuadrado = [];
foreach($nums as $n){
    $numsAlCuadrado[] = $n**2;
}
var_dump($numsAlCuadrado);

// Usando map

$numsAlCuadradov2 = array_map(fn(int $n):int => $n ** 2, $nums);
print_r($numsAlCuadradov2);

//c)

//Usando foreach
$total = 0;
foreach($nums as $n){
    $total += $n;
}
echo '<br>';
print_r($total);

//Usando reduce
echo '<br>';
$totalv2 = array_reduce($nums, fn(int $carry, int $value):int=> $carry + $value, 0);
print_r($totalv2);

// ----------------------------------------------------
/*
Haz el 1a con función anónima clásica (function), 
con closure (use, con el umbral en una variable $limite) 
y con arrow function.
*/
echo '<br>';
//funcion anonima
$f = function(int $num):bool{
    return $num > 7;
};
$mayoresQueSiete = array_filter($nums, $f);
print_r($mayoresQueSiete);
echo '<br>';
//Con closure

$limite = 7;
$f2 = function(int $num) use ($limite):bool{
    return $num > $limite;
};
$limite = 10;
$mayoresQueSeven = array_filter($nums, $f2); 
//Aqui no filtrara a los mayores que 7, sino a los mayores que 10, que es el nuevo limite 
// mala prediccion, ya que el use usa el valor anterior, sigue filtrando por 7

var_dump($mayoresQueSeven);
echo '<br>';
// Con arrow function

$greaterThan10 = array_filter($nums, fn(int $n):bool => $n > $limite);
var_dump($greaterThan10);
echo '<br>';

//Elimina repetidos y reindexa para que las claves sean 0, 1, 2...

$sinRepetidos = array_values(array_unique($nums));
var_dump($sinRepetidos);

//¿En qué posición está el 12? ¿Y el 99? Imprime un mensaje distinto en cada caso.
$valor = 12;
$key = array_search($valor, $nums, true);
if($key === false){
    echo 'Posicion no encontrada';
} else {
    echo 'Se encuentra en la posicion '. $key;
}

//$limite++ dentro de una arrow function
$fun = fn(): int =>$limite++;
echo '<br>';
echo $fun() . PHP_EOL;
echo $fun() . PHP_EOL;
//Mi prediccion es que en las 3 funciones no incrementa porque no entra dentro del scope
//Ej: 10 10

//El scope de dentro de la arrow function no afecta al del resto del codigo, se sigue quedando con el valor establecido antes y no incrementa
