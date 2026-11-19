<?php use function App\Soporte\e; ?>
<h2>Catálogo</h2>

<form action="preferencias.php" method="post">
    <label for="tema">Tema</label>
    <select name="tema" id="tema">
        <option value="claro">Claro</option>
        <option value="oscuro">Oscuro</option>
    </select>
    <button type="submit">Guardar tema</button>
</form>

<form action="preferencias2.php" method="post">
    <label for="espaciado">Espaciado</label>
    <select name="espaciado" id="espaciado">
        <option value="mayor">Mayor</option>
        <option value="menor">Menor</option>
    </select>
    <button type="submit">Guardar espaciado</button>
</form>

<form method="get" action="index.php">
    <label for="q">Buscar por título</label>
    <input id="q" name="q" value="<?= e($q) ?>">
    <button>Buscar</button>
    <a href="index.php">Ver todos</a>
</form>
<?php if ($libros === []): ?>
    <p>Sin resultados.</p>
<?php else: ?>
    <ul class="libros">
        <?php foreach ($libros as $libro): ?>
            <li><?= e($libro->titulo) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
