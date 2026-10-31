<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <title>Catálogo de la biblioteca</title>
</head>
<body>
 <h1>Catálogo de la biblioteca</h1>
 <form action="index.php" method="GET">
 <!-- Añade aquí los controles y el botón Buscar. -->
    <input type="text" name="q" id="q">
    <label for="q">Titulo o autor</label>
    <select name="genero" id="genero">
        <option value="" selected>Todos</option>
        <option value="ciencia">Ciencia</option>
        <option value="fantasia">Fantasia</option>
        <option value="terror">Terror</option>
    </select>
    <select name="tipo" id="tipo">
        <option value="" selected>Todos</option>
        <option value="papel">Papel</option>
        <option value="digital">Digital</option>
    </select>
    <input type="checkbox" name="destacados" id="destacados" value="1">
    <label for="destacados">Solo destacados</label>
    <button type="submit">Buscar</button>
 </form>
 <?php if(empty($filas)): ?>
    <p><strong>No hay libros que coincidan</strong></p>
 <?php else:?>
 <table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Género</th>
            <th>Tipo</th>
            <th>Páginas</th>
            <th>Unidades</th>
            <th>Coste de reposicion</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($filas as $fila):?>
            <tr>
                <td><?= htmlspecialchars($fila['titulo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($fila['autor'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($fila['genero'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($fila['tipo'] === 'papel' ? 'Papel' : 'Digital', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($fila['paginas'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($fila['unidades'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></td>
                <td><?= htmlspecialchars(number_format($fila['costeCentimos'] / 100, 2, '.', ''), ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8') ?></td>  
            </tr>
        <?php endforeach;?>
    </tbody>
 </table>
 <?php endif; ?>
 <h2>Resumen</h2>
 <p><strong>Número de títulos: </strong><?php htmlspecialchars($resumen['titulos'], ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8') ?></p>
 <p><strong>Unidades: </strong><?php htmlspecialchars($resumen['unidades'], ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8') ?></p>
 <p><strong>Páginas: </strong><?php htmlspecialchars($resumen['paginas'], ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8') ?></p>
 <p><strong>Coste total: </strong><?php htmlspecialchars(number_format($resumen['costeCentimos'] / 100, 2, '.', ''), ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8') ?>€</p>

 <br>
 <br>
 <br>
 <a href="./alta.php">Formulario de alta</a>
 <a href="/biblioteca-ut3/public/index.php">Catálogo inicial</a>
</body>
</html>

