<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/src/archivos.php';

$cartel = resolverCartel($_GET['nombre'] ?? null);
if (is_null($cartel)) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . $cartel['mime']);
header('X-Content-Type-Options: nosniff');
readfile($cartel['ruta']);
exit;
