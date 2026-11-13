<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Galería de carteles</title>
</head>
<body>
    <h1>Galería de carteles</h1>
    <p><a href="subir.php">Subir cartel</a></p>

    <?php if (empty($carteles)): ?>
        <p><?= e('Todavía no hay carteles') ?></p>
    <?php else: ?>
        <ul>
            <?php foreach ($carteles as $nombre): ?>
                <li>
                    <img src="/imagen.php?nombre=<?= e($nombre) ?>" alt="Cartel <?= e($nombre) ?>">
                    <p><?= e($nombre) ?></p>
                    <p><a href="subir.php?anterior=<?= e($nombre) ?>">Sustituir</a></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
