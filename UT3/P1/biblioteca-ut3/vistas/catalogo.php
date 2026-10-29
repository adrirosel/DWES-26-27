<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <title>Catálogo de la biblioteca</title>
</head>
<body>
 <h1>Catálogo de la biblioteca</h1>
 <form action="index.php" method="get">
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
</body>
</html>
