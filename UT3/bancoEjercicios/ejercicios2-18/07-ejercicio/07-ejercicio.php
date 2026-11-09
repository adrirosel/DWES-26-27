<?php

declare(strict_types=1);

function e(string $texto):string{
    return htmlspecialchars($texto, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$esPost = $metodo === 'POST';

$errores = [];

if($esPost){
    
    $paginas = $_POST['paginas'] ?? '';
    if(!is_string($paginas) || filter_var($paginas, FILTER_VALIDATE_INT) === false){
        $errores['paginas'] = 'Tipo de dato incorrecto para este campo';
    }
    if($paginas < 1 || $paginas > 3000){
        $errores['paginas'] = 'El numero de paginas debe de estar entre 1 y 3000 paginas';
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
    <?php if(isset($errores['paginas'])):?>
        <p><?= e($errores['paginas']) ?></p>
    <?php else: ?>
        <p><strong>Páginas: </strong><?= e($paginas) ?></p>
    <?php endif;?>
</body>
</html>