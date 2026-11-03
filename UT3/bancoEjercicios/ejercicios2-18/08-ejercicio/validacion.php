<?php

declare(strict_types=1);

function e(string $texto): string{
    return htmlspecialchars($texto, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$esPost = $metodo === 'POST';
$errores = [];

if($esPost){
    $genero = $_GET['genero'] ?? '';
    if(!is_string($genero)){
    $genero = '';
    $errores['genero'] = 'Error de tipo';
} elseif(!in_array($genero, ['ciencia', 'fantasia', 'terror'], true)){
    $errores['genero'] = 'Valor no permitido';
    
}
    $textarea = trim($_POST['observaciones']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="validacion.php" method="post">
        <select name="genero" id="genero">
            <option value="ciencia">Ciencia</option>
            <option value="fantasia">Fantasía</option>
            <option value="terror">Terror</option>
        </select>
        <input type="checkbox" name="destacado" value="1">
        <label for="destacado"> Destacado </label>
        <textarea name="observaciones">

        </textarea>
        <button type="submit">Enviar</button>
    </form>

    <p><?= e($textarea) ?></p>

</body>
</html>