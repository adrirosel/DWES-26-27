<?php

$catalogo = [
    $libro1 = [
        "titulo" => "El Principito", 
        "autor" => "Antoine de Saint-Exupéry",
        "paginas" => 63
    ], 
    $libro2 = [
        "titulo" => "Rebelion en la granja", 
        "autor" => "George Orwell",
        "paginas" => 64
    ], 
    $libro3 = [
        "titulo" => "El Libro Troll", 
        "autor" => "El Rubius",
        "paginas" => 65
    ], 
    $libro4 = [
        "titulo" => "Los Secretos de Youtube", 
        "autor" => "TheGrefg",
        "paginas" => 660
    ],
    $libro5 = [
        "titulo" => "Libro", 
        "autor" => "Ursula K. Le Guin", 
        "paginas" => 670
    ] 
];

foreach($catalogo as $libro){
    if($libro['paginas'] < 500){
        echo $libro['titulo'] . '<br>';
    }
    if($libro['paginas'] < 500 && $libro['autor'] === "Ursula K. Le Guin"){
        echo count($libro);
    }
    
}