<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Crear la ficha de alta</h1>

    <form action="/biblioteca-ut3/public/alta.php" method="POST">
        <select name="tipo" id="tipo">
            <option value="" selected></option>
            <option value="papel">Papel</option>
            <option value="digital">Digital</option>
        </select>
        <label for="tipo">Tipo</label>
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" maxlength="120">
        <label for="autor">Autor</label>
        <input type="text" name="autor" id="autor" maxlength="100">
        <label for="paginas">Páginas</label>
        <input type="text" name="paginas" id="paginas">
        <select name="genero" id="genero">
            <option value="" selected></option>
            <option value="ciencia">Ciencia</option>
            <option value="fantasia">Fantasía</option>
            <option value="terror">Terror</option>
        </select>
        <label for="genero">Género</label>
        <label for="unidades">Ejemplares</label>
        <input type="text" name="unidades" id="unidades">
        <label for="fechaAlta">Fecha de alta</label>
        <input type="text" name="fechaAlta" id="fechaAlta" placeholder="YYYY-MM-DD">
        <input type="checkbox" name="destacado" id="destacado" value="1">
        <label for="destacado">Destacado</label>
        <textarea name="observaciones" id="observaciones" placeholder="Escriba aquí..."></textarea>
        <label for="observaciones">Observaciones</label>
        <input type="text" name="correo" id="correo">
        <label for="correo">Correo</label>

        <button type="submit">Dar de alta</button>
    </form>
        <a href="/biblioteca-ut3/public/index.php">Volver al catálogo</a>
</body>
</html>