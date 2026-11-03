<?php

declare(strict_types=1);

function e(string $texto): string{
    return htmlspecialchars($texto, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$esPost = $metodo === 'POST';

$errores = [];

if($esPost){
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    if(!is_string($nombre)){
        $nombre = '';
        $errores['nombre'] = 'Tipo de dato no valido';
    }
    $nombre = trim($nombre);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
    if(!is_string($correo)){
        $errores['correo'] = 'Correo no valido: Tipo incorrecto';
        $correo = '';
    }
    if($correo === false || is_null($correo)){
        $errores['correo'] = 'Correo no valido';
        $correo = '';
    }

    $correoValidado = filter_var(trim($correo), FILTER_VALIDATE_EMAIL);

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
    <?php if(isset($errores['correo'])):?>
        <p><?= e($errores['correo']) ?></p>
    <?php else: ?>
        <p><?= e($correoValidado) ?></p>
    <?php endif;?>
</body>
</html>