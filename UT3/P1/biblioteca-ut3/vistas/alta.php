<?php
function e(string|int|float $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de libro</title>
</head>
<body>
    <h1>Alta de libro</h1>

    <?php if ($ficha === null): ?>
        <?php if (isset($errores['general'])): ?>
            <p><?= e($errores['general']) ?></p>
        <?php endif; ?>

        <form action="alta.php" method="post">
            <p>
                <label for="tipo">Tipo</label>
                <select id="tipo" name="tipo">
                    <option value=""<?= $valores['tipo'] === '' ? ' selected' : '' ?>></option>
                    <option value="papel"<?= $valores['tipo'] === 'papel' ? ' selected' : '' ?>>Papel</option>
                    <option value="digital"<?= $valores['tipo'] === 'digital' ? ' selected' : '' ?>>Digital</option>
                </select>
                <?php if (isset($errores['tipo'])): ?><span><?= e($errores['tipo']) ?></span><?php endif; ?>
            </p>
            <p>
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" value="<?= e($valores['titulo']) ?>">
                <?php if (isset($errores['titulo'])): ?><span><?= e($errores['titulo']) ?></span><?php endif; ?>
            </p>
            <p>
                <label for="autor">Autor</label>
                <input type="text" id="autor" name="autor" value="<?= e($valores['autor']) ?>">
                <?php if (isset($errores['autor'])): ?><span><?= e($errores['autor']) ?></span><?php endif; ?>
            </p>
            <p>
                <label for="paginas">Páginas</label>
                <input type="text" id="paginas" name="paginas" value="<?= e($valores['paginas']) ?>">
                <?php if (isset($errores['paginas'])): ?><span><?= e($errores['paginas']) ?></span><?php endif; ?>
            </p>
            <p>
                <label for="genero">Género</label>
                <select id="genero" name="genero">
                    <option value=""<?= $valores['genero'] === '' ? ' selected' : '' ?>></option>
                    <option value="ciencia"<?= $valores['genero'] === 'ciencia' ? ' selected' : '' ?>>Ciencia</option>
                    <option value="fantasia"<?= $valores['genero'] === 'fantasia' ? ' selected' : '' ?>>Fantasía</option>
                    <option value="terror"<?= $valores['genero'] === 'terror' ? ' selected' : '' ?>>Terror</option>
                </select>
                <?php if (isset($errores['genero'])): ?><span><?= e($errores['genero']) ?></span><?php endif; ?>
            </p>
            <p>
                <label for="unidades">Ejemplares o licencias</label>
                <input type="text" id="unidades" name="unidades" value="<?= e($valores['unidades']) ?>">
                <?php if (isset($errores['unidades'])): ?><span><?= e($errores['unidades']) ?></span><?php endif; ?>
            </p>
            <p>
                <label for="fechaAlta">Fecha de alta</label>
                <input type="text" id="fechaAlta" name="fechaAlta" value="<?= e($valores['fechaAlta']) ?>" placeholder="YYYY-MM-DD">
                <?php if (isset($errores['fechaAlta'])): ?><span><?= e($errores['fechaAlta']) ?></span><?php endif; ?>
            </p>
            <p>
                <label for="destacado">Destacado</label>
                <input type="checkbox" id="destacado" name="destacado" value="1"<?= $valores['destacado'] ? ' checked' : '' ?>>
                <?php if (isset($errores['destacado'])): ?><span><?= e($errores['destacado']) ?></span><?php endif; ?>
            </p>
            <p>
                <label for="observaciones">Observaciones</label>
                <textarea id="observaciones" name="observaciones"><?= e($valores['observaciones']) ?></textarea>
                <?php if (isset($errores['observaciones'])): ?><span><?= e($errores['observaciones']) ?></span><?php endif; ?>
            </p>
            <p>
                <label for="correo">Correo</label>
                <input type="text" id="correo" name="correo" value="<?= e($valores['correo']) ?>">
                <?php if (isset($errores['correo'])): ?><span><?= e($errores['correo']) ?></span><?php endif; ?>
            </p>
            <p>
                <button type="submit">Dar de alta</button>
            </p>
        </form>
    <?php else: ?>
        <p>Se ha dado de alta el libro. Confirmación enviada a <?= e($valores['correo']) ?>.</p>

        <h2>Ficha del libro</h2>
        <p>Título: <?= e($ficha['titulo']) ?></p>
        <p>Autor: <?= e($ficha['autor']) ?></p>
        <p>Tipo: <?= e($ficha['tipo'] === 'papel' ? 'Papel' : 'Digital') ?></p>
        <p>Género: <?= e($ficha['genero']) ?></p>
        <p>Páginas: <?= e($ficha['paginas']) ?></p>
        <p>Unidades: <?= e($ficha['unidades']) ?></p>
        <p>Fecha: <?= e($ficha['fechaAlta']) ?></p>
        <p>Destacado: <?= $ficha['destacado'] ? 'Sí' : 'No' ?></p>
        <p>Observaciones: <?= $ficha['observaciones'] === '' ? 'Sin observaciones' : e($ficha['observaciones']) ?></p>
        <p>Coste: <?= e(number_format($ficha['costeCentimos'] / 100, 2, '.', '')) ?> €</p>

        <h2>Catálogo actual</h2>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Género</th>
                    <th>Tipo</th>
                    <th>Páginas</th>
                    <th>Unidades</th>
                    <th>Coste de reposición</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filas as $fila): ?>
                    <tr>
                        <td><?= e($fila['titulo']) ?></td>
                        <td><?= e($fila['autor']) ?></td>
                        <td><?= e($fila['genero']) ?></td>
                        <td><?= e($fila['tipo'] === 'papel' ? 'Papel' : 'Digital') ?></td>
                        <td><?= e($fila['paginas']) ?></td>
                        <td><?= e($fila['unidades']) ?></td>
                        <td><?= e(number_format($fila['costeCentimos'] / 100, 2, '.', '')) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Resumen</h2>
        <p>Número de títulos: <?= e($resumen['titulos']) ?></p>
        <p>Unidades: <?= e($resumen['unidades']) ?></p>
        <p>Páginas: <?= e($resumen['paginas']) ?></p>
        <p>Coste total: <?= e(number_format($resumen['costeCentimos'] / 100, 2, '.', '')) ?> €</p>
    <?php endif; ?>

    <p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
