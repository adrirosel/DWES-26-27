<?php
use function App\Soporte\e;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Alta de un material</title></head>
<body>
<h1>Alta de un material</h1>
<?php if ($creado === null): ?>
    <!-- Bloque de errores proporcionado. Cada entrada identifica el campo y su mensaje. -->
<?php if ($errores !== []): ?>
    <ul role="alert">
        <?php foreach ($errores as $campo => $mensaje): ?>
            <li><?= e($campo) ?>: <?= e($mensaje) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
    <!-- COMPLETAR 4. Formulario POST multipart con controles HTML estáticos. -->
    <form method="post" action="alta.php" enctype="multipart/form-data">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre">
            <br>
            <label for="fabricante">Fabricante</label>
            <input type="text" name="fabricante" id="fabricante">
            <br>
            <label for="unidades">Unidades</label>
            <input type="text" name="unidades" id="unidades">
            <br>
            <select name="categoria" id="categoria">
                <option value="">Elige una categoría</option>
                <option value="colectivo">Colectivo</option>
                <option value="raqueta">Raqueta</option>
                <option value="fitness">Fitness</option>
            </select>
            <br>
            <label for="fechaAlta">Fecha de alta</label>
            <input type="text" name="fechaAlta" id="fechaAlta">
            <br>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg,image/webp,image/png">
            <button type="submit">Guardar material</button>

    </form>
<?php else: ?>
    <!-- Confirmación proporcionada. Solo aparece cuando asignas $creado. -->
    <h2>Material registrado</h2>
    <dl>
        <dt>Nombre</dt><dd><?= e($creado->nombre()) ?></dd>
        <dt>Fabricante</dt><dd><?= e($creado->fabricante()) ?></dd>
        <dt>Unidades</dt><dd><?= $creado->unidades() ?></dd>
        <dt>Categoría</dt><dd><?= e($creado->categoria()) ?></dd>
        <dt>Fecha de alta</dt><dd><?= e($creado->fechaAlta()?->format('Y-m-d') ?? 'Sin fecha') ?></dd>
    </dl>
    <p>La colección de este envío contiene <?= count($inventario->todos()) ?> materiales.</p>
    <?php if ($creado->imagen() !== null): ?>
        <img src="imagen.php?nombre=<?= e($creado->imagen()) ?>"
             alt="Imagen del material creado" width="180">
    <?php else: ?>
        <p>Sin imagen</p>
    <?php endif; ?>
    <p><a href="alta.php">Nueva alta</a></p>
<?php endif; ?>
<p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
