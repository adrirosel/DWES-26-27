<?php
// Con un array de páginas, comprueba con array_any si existe algún libro con más de 1000 páginas y
// con array_all si todos tienen un número de páginas mayor que 0.

declare(strict_types=1);

$libros = [
    "El Quijote" => 1234,
    "1984" => 321,
    "Cien años de soledad" => 10,
    "Dune" => 235,
];

$existe = array_any(
    $libros,
    fn (int $n):bool => $n > 1000
);
if($existe) echo 'Si existe' . '<br>';

$todosTienen = array_all(
    $libros, 
    fn (int $n): bool => $n > 0
);
if($todosTienen) echo 'Todos tienen mas de 0 paginas';