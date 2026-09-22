<?php

$novedades1 = [2, 4, 6, 8, 10];
$novedades2 = [12, 14, 16, 18, 20];

unset($novedades1[0]);
$superArray = array_merge($novedades1, $novedades2);

sort($superArray);

foreach($superArray as $clave => $valor){
    echo "$clave: $valor<br>";
}