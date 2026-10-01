<?php

declare(strict_types=1);

function doble(int $n):int{
    return $n * 2;
}
function cuadrado(int $n): int{
    return $n ** 2;
}

function aplicar(int $n, callable $callback):int{
    return $callback($n);
}

$resultado = aplicar(5, 'cuadrado');
echo $resultado . '<br>';

$resultado2 = aplicar(5, 'doble');
echo $resultado2;