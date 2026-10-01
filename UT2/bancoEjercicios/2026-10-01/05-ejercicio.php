<?php

declare(strict_types=1);
require_once __DIR__ . '/datos.php';
$formato = array_map(
     fn (array $a): string => $a['titulo'] . '-' . $a['paginas'] . ' páginas',
     $libros
);

foreach($formato as $libro){
    echo $libro . '<br>';
}