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
    
];

foreach($catalogo as $libro){
    foreach($libro as $clave => $valor){
        echo "$clave: $valor<br>";
    }
}