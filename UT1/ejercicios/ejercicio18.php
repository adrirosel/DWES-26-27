<?php

$catalogo = [
    $libro1 = [
        "titulo" => "El Principito", 
        "autor" => "Antoine de Saint-Exupéry",
    ], 
    $libro2 = [
        "titulo" => "Rebelion en la granja", 
        "autor" => "George Orwell",
    ], 
    $libro3 = [
        "titulo" => "El Libro Troll", 
        "autor" => "El Rubius",
    ], 
    $libro4 = [
        "titulo" => "Los Secretos de Youtube", 
        "autor" => "TheGrefg",
    ],
    $libro5 = [
        "titulo" => "Libro", 
        "autor" => "Ursula K. Le Guin", 
    ] 
];

foreach($catalogo as $libro){
    if($libro['autor'] === "Ursula K. Le Guin") echo $libro['titulo'];
}