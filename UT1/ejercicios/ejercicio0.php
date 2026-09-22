<?php
echo "Informacion sobre libro";
$titulo = "El Principito";
$autor = "Antoine de Saint-Exupéry";
$numeroPaginas = "319";
$precio = 21.59;
$disponible = true;
$mensajeDisponible = $disponible 
    ? 'Disponible' 
    : 'Agotado';

$mensaje = "Titulo: " . $titulo . "\n autor: " . $autor . "\n numero de paginas: " . $numeroPaginas
    . "\n precio: " . $precio . "\n estado: " . $mensajeDisponible;

echo $mensaje;