<?php

declare(strict_types=1);

function e(string $texto): string{
    return htmlspecialchars($texto, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}

$titulo = '   <Dune> & "edición"   ';
$guardado = trim($titulo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p><?= e($guardado) ?></p>
    <br>
    <input type="text" name="titulo" value="<?= e($guardado) ?>">
</body>
</html>