<?php

declare(strict_types=1);

$paginas = [123, 456, 789];

$sumar = function (int ...$array): int{
    return array_sum($array);
};

//Desempaquetando el array

var_dump($sumar(...$paginas));

//Equivalente: 

$sumarv2 = function(int $a, int $b, int $c): int{
    return $a + $b + $c;
};

echo '<br>';
var_dump($sumarv2(123, 456, 789));