<?php

declare(strict_types=1);

$titulo = $_POST['titulo'] ?? '';
echo $titulo . '<br>';
$autor = $_POST['autor'] ?? '';
echo $autor . '<br>';
$paginas = $_POST['paginas'] ?? null;
echo $paginas . '<br>';