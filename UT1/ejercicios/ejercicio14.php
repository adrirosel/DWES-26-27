<?php

$generos = ["Fantasia", "Terror", "Ciencia ficcion", "comedia", "tragedia"];
$generos[] = "suspense";
$generos[2] = "historica";
unset($generos[0]);

foreach($generos as $genero){
    echo $genero . '<br>';
}
