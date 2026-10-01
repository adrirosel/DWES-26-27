<?php

declare(strict_types=1);
require_once __DIR__ . '/datos.php';

$total = array_reduce(
    $libros, 
    fn(int $s, array $p): int => $s + $p['paginas'],
    0
);
echo $total;
