<?php

declare(strict_types=1);

function ficha(string $titulo, string $autor): string{
    return $titulo . ' - ' . $autor;
}

$r = ficha(
    autor: 'Miguel de Cervantes',
    titulo: 'Don Quijote',
);

echo $r;