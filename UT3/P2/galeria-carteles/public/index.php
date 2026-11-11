<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/src/archivos.php';

$carteles = listarCarteles();
require dirname(__DIR__) . '/vistas/galeria.php';
