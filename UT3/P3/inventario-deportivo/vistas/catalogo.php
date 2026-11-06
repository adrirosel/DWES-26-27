<?php
use function App\Soporte\e;
use App\Modelo\Material;
use App\Servicio\Inventario;
$materiales = (new Inventario(require dirname(__DIR__) . '/datos/materiales.php'))->todos();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Catálogo del inventario</title></head>
<body>
<h1>Catálogo del inventario</h1>
<p><a href="alta.php">Dar de alta un material</a></p>
<!-- Bloque de errores proporcionado. Cada entrada identifica el campo y su mensaje. -->
<?php if ($errores !== []): ?>
    <ul role="alert">
        <?php foreach ($errores as $campo => $mensaje): ?>
            <li><?= e($campo) ?>: <?= e($mensaje) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<!-- COMPLETAR 1. Formulario GET con controles HTML estáticos. -->
<form action="/inventario-deportivo/public/index.php" method="get">
    <input type="text" name="q" id="q">
    <label for="q">Nombre o fabricante</label>

    <select name="categoria" id="categoria">
        <option value="Todas"></option>
        <option value="Colectivo">Colectivo</option>
        <option value="Raqueta">Raqueta</option>
        <option value="Fitness">Fitness</option>
    </select>

    <button type="submit">Buscar</button>
</form>

<?php if ($errores === []): ?>
    <!-- COMPLETAR 3. Tabla de materiales o mensaje si no hay coincidencias. -->
    <?php if (empty($materiales)):?>
        <?= e('No hay materiales que coincidan') ?>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fabricante</th>
                    <th>Unidades</th>
                    <th>Categoría</th>
                    <th>Fecha de alta</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($materiales as $material):?>
                    <tr>
                        <td><?= e($material->nombre()) ?></td>
                        <td><?= e($material->fabricante()) ?></td>
                        <td><?= e($material->unidades()) ?></td>
                        <td><?= e($material->categoria()) ?></td>
                        <td><?= is_null($material->fechaAlta()) ? e('Sin fecha') : e($material->fechaAlta()->format('Y-m-d')) ?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php endif; ?>
<?php endif; ?>
<p><a href="index.php">Limpiar filtros</a></p>
</body>
</html>
