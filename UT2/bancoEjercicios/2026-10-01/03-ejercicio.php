<?php

$factor = 25;

$p = fn(int $n):float => ($n * $factor) / 2;

$valor = $p(6);

echo $valor;