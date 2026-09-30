<?php

declare(strict_types=1);
require_once __DIR__ . '/datos.php';

//filtra libros por genero
function filtrarGenero(array $catalogo, string $genero): array{
    if($genero === 'todos') return $catalogo;

    $resultado = [];

    foreach($catalogo as $libro){
        if($libro['genero'] === $genero){
            $resultado[] = $libro;
        }
    }
    return $resultado;
}

//muestra los titulos de los libros del catalogo
function mostrarTitulos(array $catalogo): void {
    ?>
    <ul>
        <?= htmlspecialchars('Libros: ') ?>
        <?php foreach($catalogo as $libros): ?>
        <li>
            <?= htmlspecialchars($libros['titulo']) ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php
}