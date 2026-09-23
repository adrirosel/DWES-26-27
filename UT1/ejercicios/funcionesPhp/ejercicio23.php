<?php

declare(strict_types=1);

// Explica por qué el siguiente programa no funciona como probablemente espera su autor y reescríbelo 
// sin usar global. 
// $contador = 0; 
// function incrementar() { 
// $contador++; 
// } 
// incrementar(); 
// echo $contador; 

//El siguiente programa no funciona porque, desde el ambito de una funcion
//no puedes acceder sin mas a la variable que esta fuera de la funcion

$contador = 0;
function incrementar(int &$contador):void {
    $contador++;
} 

incrementar($contador); 
echo $contador;
