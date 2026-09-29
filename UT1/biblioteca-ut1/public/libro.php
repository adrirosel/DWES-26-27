<?php

declare(strict_types=1);
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$id = $_GET['id'] ?? null;


$libroBuscado = buscarPorId($catalogo, (int) $id);

if($libroBuscado !== null){
    foreach($libroBuscado as $clave){
        echo $clave . '<br>';
    }
    $fecha = new DateTimeImmutable($libroBuscado['fechaAlta']);
    $fechaDevolucion = $fecha->modify('+15days');
    $fechaDevolucionFormat = $fechaDevolucion->format('d/m/Y');
    echo "Fecha de devolucion simulada: $fechaDevolucionFormat" . '<br>';

    $diferenciaDias = $fecha->diff($fechaDevolucion);

    echo 'Desde la fecha de alta han pasado ' . (string) $diferenciaDias->days . 'dias';
} else {
    echo "Libro no encontrado";
}

?>

