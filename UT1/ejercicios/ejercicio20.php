<?php

$paginas = [90, 640, 710, 212, 74, 15, 1024, 2032];
sort($paginas);

echo "Minimo: $paginas[0]<br>";
echo "Maximo: $paginas[7]<br>";

$suma = 0;

foreach($paginas as $pagina){
    $suma += $pagina;
};

$media = $suma / count($paginas);

echo round($media, 2);