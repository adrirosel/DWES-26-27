<?php
/*Escribe primero un switch y después un match que 
transformen los códigos 'F', 'CF' y 'T' en 'Fantasía',
'Ciencia ficción' y 'Terror'. Para cualquier otro
 valor deben devolver 'Desconocido'. */

// switch

$codigo = 'T';

switch($codigo){
    case 'F': 
        echo 'Fantasia';
        break;
    case 'CF': 
        echo 'Ciencia Ficcion';
        break;
    case 'T': 
        echo 'Terror';
        break;
    default: 
        echo 'Desconocido';
        break;
}

// match

$genero = match ($codigo){
    'F' => 'Fantasia', 
    'CF' => 'Ciencia Ficcion', 
    'T' => 'Terror', 
    default => 'Desconocido',
};
