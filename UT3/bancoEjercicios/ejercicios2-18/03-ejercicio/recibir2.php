<?php

declare(strict_types=1);

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$esPost = $metodo === 'POST';
$titulo = '';

if ($esPost) {
    $entrada = $_POST['titulo'] ?? '';
    if (!is_string($entrada)) {
        $entrada = '';
    }
    $titulo = trim($entrada);
}
echo $titulo;