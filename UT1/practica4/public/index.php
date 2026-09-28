<?php

declare(strict_types=1);
require_once __DIR__ . '/funciones.php';
require_once __DIR__ . '/datos.php';


// Permite flitrar con ?genero y ?disponible=1

$genero = strtolower(trim((string)$_GET['genero'] ?? null));
$disponible = $_GET['disponible'] ?? null;

// if(array_key_exists((string)$genero, $sintaxisGeneros)){
//     $genero = $sintaxisGeneros[$genero];
// }

$catalogoFinal = $libros;

if($genero !== null){
    $catalogoFinal = filtrarPorGenero($catalogoFinal, $genero);
}
if($disponible === '1'){
    $catalogoFinal = filtrarDisponibles($catalogoFinal);
}
//Mostrar el catalogo completo
?>

<h1>
    <?= htmlspecialchars("Catalogo de libros") ?>
</h1>
<ul>
    <?php foreach($catalogoFinal as $libro): ?>
        <li>
            <?= "Titulo: " . htmlspecialchars($libro['titulo'])?><br>
            <?= "Autor: " . htmlspecialchars($libro['autor']) ?><br>
            <?= "Genero: " . htmlspecialchars($libro['genero']) ?><br>
            <?= "Paginas: " . htmlspecialchars((string)$libro['paginas']) ?><br>
            <?= "Disponible: "?>
            <?php 
            if($libro['disponible'] === true) {
                echo 'Si';}
            else {echo 'No';} ?>
            <?php 
                $fechaAlta = new DateTimeImmutable($libro['fechaAlta']);
            ?>
            <br><?= "Fecha Alta: " . htmlspecialchars($fechaAlta->format('d/m/Y')) ?><br>
            <?php 
                $hoy = new DateTimeImmutable();
                $diferenciaDias = $fechaAlta->diff($hoy);
                $revision = $hoy->modify('+30days');
            ?>
            <?= "Dias transcurridos: " . htmlspecialchars((string) $diferenciaDias->days) ?><br>
            <?=  "Fecha de revision: " . htmlspecialchars((string) $revision->format('d/m/Y'))?>
        </li>
        <br>
    <?php endforeach;?>
</ul>

<?php


//Muestra numero de resultados y media de paginas de los resultados

$numeroResultados = count($catalogoFinal);

?>
<p><strong>Numero de resultados: </strong> <?= htmlspecialchars((string)$numeroResultados) ?> </p><br>
<p><strong>Media de paginas: </strong> <?= htmlspecialchars((string)calcularMediaPaginas($catalogoFinal)) ?> </p><br>

<?php 
//Mostrar el libro con mas paginas
$libroMasLargo = obtenerLibroMasLargo($libros);
?>
<p><strong>Libro con mas paginas: </strong> 
<?= htmlspecialchars($libroMasLargo['titulo']) ?>, paginas: <?= htmlspecialchars((string)$libroMasLargo['paginas']) ?> </p><br>



