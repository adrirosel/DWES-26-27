<?php

$libro = [
    "id" => 1, 
    "titulo" => "El Extranjero", 
    "autor" => "Albert Camus",
    "paginas" => 96, 
    "disponible" => 'true',
];

$libro['disponible'] = 'false';

foreach($libro as $clave => $valor){
    echo "$clave: $valor<br>";
}