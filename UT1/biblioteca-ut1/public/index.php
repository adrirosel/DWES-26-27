<?php

declare(strict_types=1);
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$genero = strtolower(trim((string)($_GET['genero'] ?? '')));
$disponible = $_GET['disponible'] ?? null;
$texto = strtolower(trim((string)($_GET['q'] ?? '')));
// $orden = strtolower(trim((string)($_GET['titulo'] || $_GET['paginas']?? '')));

$catalogoFinal = $catalogo;

if($genero !== ''){
    $catalogoFinal = filtrarPorGenero($catalogoFinal, $genero);
}
if($disponible === '1'){
    $catalogoFinal = filtrarDisponibles($catalogoFinal);
}
if($texto !== ''){
    $catalogoFinal = filtrarPorTexto($catalogoFinal, $texto);
}

// if($orden === 'paginas'){
//     sort($catalogoFinal, (int) $orden);
// } else {
    
// }

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

$numeroResultados = count($catalogoFinal);

?>

<p><strong>Numero de resultados: </strong> <?= htmlspecialchars((string)$numeroResultados) ?> </p><br>