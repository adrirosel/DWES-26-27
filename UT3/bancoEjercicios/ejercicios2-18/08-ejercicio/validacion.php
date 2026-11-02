<?php

declare(strict_types=1);

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'POST';
$esGet = $metodo === 'GET';
$errores = [];

if($esGet){
    $genero = $_GET['genero'] ?? '';
    if(!is_string($genero)){
    $genero = '';
    $errores['genero'] = 'Error de tipo';
} elseif(!in_array($genero, ['ciencia', 'fantasia', 'terror'], true)){
    $errores['genero'] = 'Valor no permitido';
}
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
    form
</body>
</html>