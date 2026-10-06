<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

// El casting lo hacemos una vez tengamos el valor
$id = (int) ($_GET['id'] ?? 0);

$videojuego = buscarPorId($videojuegos, $id);

if ($videojuego === null) {
    
    ?>
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Videojuego no encontrado</title>
    </head>
    <body>
        <p>Videojuego con id <?= $id ?> no encontrado</p>
    </body>
    </html>
    <?php
    exit;
}

// Prepara las fechas y los valores que necesita la ficha.

$fechaLanzamiento = new DateTimeImmutable($videojuego['fechaLanzamiento']);

$hoy = new DateTimeImmutable();

$intervalo = $hoy->diff($fechaLanzamiento);

$diasTranscurridos = $intervalo->days; 
$finNovedad = $fechaLanzamiento->modify('+30days');
// El estado dependía si era Novedad o no (Corregido)
$estado = $diasTranscurridos > 30 ? 'Catálogo' : 'Novedad'

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
        <dd><?= htmlspecialchars($estado) ?></dd>
    </dl>

    <!-- Cuidado con las rutas -->
    <p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
