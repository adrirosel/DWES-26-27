<?php

declare(strict_types=1);

function e(string $texto): string{
    return htmlspecialchars($texto, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}

$errores = [];

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$esPost = $metodo === 'POST';

if($esPost){
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    if(!is_string($titulo)){
        $titulo = '';
        $errores['titulo'] = 'El título debe de ser una cadena de texto';
    }
    if(trim($titulo) === ''){
        $errores['titulo'] = 'El título es un campo obligatorio';
    }
    if(mb_strlen(trim($titulo), 'UTF-8') > 120) $errores['titulo'] = 'No puede superar 120 caracteres en este campo';
    $titulo = trim($titulo);
    
    if(!is_string($autor)){
        $autor = '';
        $errores['autor'] = 'El autor debe de ser una cadena de texto';
    }
    if($autor === ''){
        $errores['autor'] = 'El autor es un campo obligatorio';
    }
    $autor = trim($autor);

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
    <?php if(isset($errores['titulo'])):?>
        <p><?= e($errores['titulo']) ?></p>
    <?php else:?>
        <p><strong>Título: </strong><?= e($titulo) ?></p>
    <?php endif;?>

    <?php if(isset($errores['autor'])):?>
        <p><?= e($errores['autor']) ?></p>
    <?php else:?>
        <p><strong>Autor: </strong><?= e($autor) ?></p>
    <?php endif;?>
</body>
</html>