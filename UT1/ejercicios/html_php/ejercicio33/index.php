<?php

require_once __DIR__ . '/funciones.php';
require_once __DIR__ . '/datos.php';

$genero = $_GET['genero'] ?? 'todos';
$genero = strtolower(trim($genero));

$respuesta = filtrarGenero($catalogo, $genero);

sort($respuesta);

echo 'Resultados: ' . count($respuesta) . '<br><br>';

?>

<ul>
    <?= htmlspecialchars('Libros: ') ?>
    <?php foreach($catalogo as $libros): ?>
    <li>
        <?= htmlspecialchars($libros['titulo']) ?>
    </li>
    <?php endforeach; ?>
</ul>
