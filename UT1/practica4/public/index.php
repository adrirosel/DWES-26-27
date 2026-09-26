<?php

declare(strict_types=1);
require_once __DIR__ . '/funciones.php';
require_once __DIR__ . '/datos.php';

//Mostrar el catalogo completo
?>

<h1>
    <?= htmlspecialchars("Catalogo de libros") ?>
</h1>
<ul>
    <?php foreach($libros as $libro): ?>
        <li>
            <?= htmlspecialchars($libro) ?>
        </li>
    <?php endforeach;?>
</ul>