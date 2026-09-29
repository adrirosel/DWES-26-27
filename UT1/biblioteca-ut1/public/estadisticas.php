<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$totalLibros = count($catalogo);

$numDisponibles = count(filtrarDisponibles($catalogo));
$numNoDisponibles = $totalLibros - $numDisponibles;
$mediaPaginas = calcularMediaPaginas($catalogo);
$libroMasLargo = obtenerLibroMasLargo($catalogo);

$hoy = new DateTimeImmutable();
$fechaInforme = $hoy->format('d/m/Y H:i');

$cienciaFiccion = 0;
$fantasia = 0; 
$distopia = 0;
$terror = 0;

foreach($catalogo as $libros){
    if($libros['genero'] === 'ciencia ficcion'){
        $cienciaFiccion += 1;
    } elseif ($libros['genero'] === 'fantasia'){
        $fantasia += 1;
    } elseif($libros['genero'] === 'distopia'){
        $distopia += 1;
    } else {
        $terror += 1;
    }
}

echo 'Estadisticas: ' . '<br>';
echo 'Numero total de libros: ' . $totalLibros . '<br>';
echo 'Numero de disponibles: ' . $numDisponibles . '<br>';
echo 'Numero de NO disponibles: ' . $numNoDisponibles . '<br>';
echo 'Media de paginas: ' . $mediaPaginas . '<br>';
echo 'Libro con mayor numero de paginas: ' . $libroMasLargo['titulo'] . '<br>';
echo 'Numero de libros por genero: ciencia ficcion ' . $cienciaFiccion . 
                                   ', fantasia ' . $fantasia . 
                                   ', distopia ' . $distopia . 
                                   ', terror ' . $terror;                      
?>
