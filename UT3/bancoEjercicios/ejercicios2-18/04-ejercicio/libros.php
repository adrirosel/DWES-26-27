<?php

declare(strict_types=1);

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'POST';
$esGet = $metodo === 'GET';

if($esGet){
    $q = $_GET['q'] ?? '';
    if(!(is_string($q))){
        echo "Entrada no valida";
    }
    $q2 = trim($q);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Resultado/s encontrado/s: <?= htmlspecialchars($q, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8') ?></p>

    <a href="/busqueda.php">Volver al formulario</a>
</body>
</html>