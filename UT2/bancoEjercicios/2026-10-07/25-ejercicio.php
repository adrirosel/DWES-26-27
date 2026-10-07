<?php

declare(strict_types=1);

$informacion = [
    'titulo' => 'Dune', 
    'autor' => 'Frank Herbert'
];

['titulo' => $t, 'autor' => $a] = $informacion;

echo $t . ' / ' . $a;