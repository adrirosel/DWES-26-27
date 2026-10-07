<?php

declare(strict_types=1);



$catalogo = [
    10 => ['titulo' => 'Metamorfosis', 'autor' =>'Franz Kafka'],
    20 => ['titulo' => 'Don Quijote', 'autor' =>'Miguel de Cervantes'],
    30 => ['titulo' => 'Dune', 'autor' =>'Frank Herbert'],
];

uasort($catalogo, 
    fn(array $a, array $b): int => $a['titulo'] <=> $b['titulo']);

foreach($catalogo as $clave => $libro){
    echo $clave . ': ' . $libro['titulo'];
    echo '<br>';
}

//A diferencia de usort, uasort conserva las claves de cada elemento
//Si queremos que las claves apareciesen en orden natural deberiamos de hacer
//array_values, en este caso en concreto como cada libro va a asociado a un id, no es 
//buena practica