<?php

$titulos = [];
$titulos[] = 'Cien años de soledad';
$titulos[] = 'El principito';
$titulos[] = 'Don Quijote de la Mancha';
$titulos[] = 'La sombra del viento';

?>
<ul>
    <?php foreach ($titulos as $titulo): ?>
        <li>
            <?= $titulo ?>
        </li>
    <?php endforeach; ?>
</ul>
