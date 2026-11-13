<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $esSustitucion ? e('Sustituir cartel') : e('Subir cartel') ?></title>
</head>
<body>
    <h1><?= $esSustitucion ? e('Sustituir cartel') : e('Subir cartel') ?></h1>
    <p><a href="index.php">Volver a la galería</a></p>

    <?php if ($esSustitucion && !empty($anterior) && empty($guardado)): ?>
        <p>Cartel actual:</p>
        <img src="/imagen.php?nombre=<?= e($anterior['nombre']) ?>" alt="Cartel actual">
        <p><?= e($anterior['nombre']) ?></p>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <ul role="alert">
            <?php foreach ($errores as $campo => $texto): ?>
                <li><?= e((string) $campo) ?>: <?= e($texto) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($mensaje)): ?>
        <p><?= e($mensaje) ?></p>
    <?php endif; ?>

    <?php if (!empty($guardado)): ?>
        <img src="/imagen.php?nombre=<?= e($guardado) ?>" alt="Cartel guardado">
        <p><?= e($guardado) ?></p>
    <?php endif; ?>

    <?php
    $action = 'subir.php';
    if ($esSustitucion) {
        $nombreAction = $guardado ?? ($anterior['nombre'] ?? '');
        if (!empty($nombreAction)) {
            $action = 'subir.php?anterior=' . rawurlencode($nombreAction);
        }
    }
    ?>
    <form method="post" action="<?= e($action) ?>" enctype="multipart/form-data">
        <p>
            <label for="imagen">Imagen</label>
            <input id="imagen" name="imagen" type="file"
                   accept="image/jpeg,image/png,image/webp">
        </p>
        <p>
            <button type="submit">Guardar</button>
        </p>
    </form>
</body>
</html>
