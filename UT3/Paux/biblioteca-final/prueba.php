<?php

declare(strict_types=1);

use AdrianRosel\Biblioteca\Modelo\LibroDigital;
use AdrianRosel\Biblioteca\Modelo\LibroPapel;

require_once __DIR__ . '/vendor/autoload.php';

$libroPapel = new LibroPapel('Dune', 'Frank Herbert', 412, 'ciencia', 2);

echo $libroPapel->costeReparacionCentimos() . PHP_EOL;

$libroDigital = new LibroDigital('Solaris', 'Mi tio', 412, 'fantasia', 3);

echo $libroDigital->costeReparacionCentimos();

// $libroDigital2 = new LibroDigital('miau', 'guau', 0, 'dj', 1);

$libroDigital->prestar();
// $libroDigital->prestar();

// $libroDigital->actualizarDatos('Miau', 'guau', -1, 'hah', 1);
echo $libroDigital->titulo();