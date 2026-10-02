<?php

require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$id = $_GET['id'] ?? (int)'0';

$videojuego = buscarPorId($videojuegos, $id);

if ($videojuego === null) {
    echo "Videojuego no encontrado / no existente"
    ?>
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Videojuego no encontrado</title>
    </head>
    <body>
    </body>
    </html>
    <?php
    exit;
}

// Prepara las fechas y los valores que necesita la ficha.

$fechaLanzamiento = new DateTimeImmutable($videojuego['fechaLanzamiento']);
// De dónde saco la fecha??
$hoy = new DateTimeImmutable();

$intervalo = $hoy->diff($fechaLanzamiento);

$diasTranscurridos = $intervalo->days; //0? Habrá que calcular algo, no?
$finNovedad = $fechaLanzamiento->modify('+30days');
$estado = $videojuego['disponible'];

// COMPLETAR los cálculos anteriores utilizando los datos del videojuego.
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ficha del videojuego</title>
</head>
<body>
    <h1><?= htmlspecialchars($videojuego['titulo'] ?? '') ?></h1>

    <dl>
        <dt>Estudio</dt>
        <dd><?= htmlspecialchars($videojuego['estudio'] ?? '') ?></dd>

        <dt>Género</dt>
        <dd><?= htmlspecialchars($videojuego['genero'] ?? '') ?></dd>

        <dt>Plataforma</dt>
        <dd><?= htmlspecialchars($videojuego['plataforma'] ?? '') ?></dd>

        <dt>Precio</dt>
        <dd>
            <?php if ($videojuego !== null): ?>
                <?= number_format($videojuego['precio'], 2, ',', '.') ?> €
            <?php endif; ?>
        </dd>

        <dt>Puntuación</dt>
        <dd><?= $videojuego['puntuacion'] ?? '' ?></dd>

        <dt>Fecha de lanzamiento</dt>
        <dd><?= htmlspecialchars($fechaLanzamiento->format('d/m/Y')); ?></dd>

        <dt>Días desde el lanzamiento</dt>
        <dd><?= htmlspecialchars((string)$diasTranscurridos); ?></dd>

        <dt>Fin del periodo de novedad</dt>
        <dd><?= htmlspecialchars($finNovedad->format('d/m/Y')); ?></dd>

        <dt>Estado</dt>
        <dd>
            <?php if ($estado === true): ?>
                <?= htmlspecialchars('Disponible') ?>
            <?php elseif($estado !== true): ?>
                <?= htmlspecialchars('No disponible') ?> 
            <?php endif; ?>
        </dd>
        <?if($hoy > $finNovedad):?>
            <?= htmlspecialchars('Catálogo') ?>
 
        <?endif;?>
    </dl>

    <p><a href="/public/index.php">Volver al catálogo</a></p>
</body>
</html>
