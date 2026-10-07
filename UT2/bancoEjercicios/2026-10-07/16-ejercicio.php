<?php

declare(strict_types=1);

$texto = 'Desarrollo Web con PHP';

$contienePHP = str_contains($texto, 'PHP');

echo $contienePHP ? 'contiene PHP' : 'No contiene PHP';
echo '<br>';
$posicionPHP = strpos($texto, 'PHP');

echo "La palabra PHP se situa en la posicion $posicionPHP";