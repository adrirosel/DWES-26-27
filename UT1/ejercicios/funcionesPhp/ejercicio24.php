<?php

declare(strict_types=1);

// function duplicarValor($n) { 
// $n *= 2; 
// } 
// function duplicarReferencia(&$n) { 
// $n *= 2; 
// } 
// $a = 5; 
// $b = 5; 
// duplicarValor($a); 
// duplicarReferencia($b); 
// echo "$a - $b";

//La salida seria '-5', esto ocurre por el siguiente motivo: 
//en la primera funcion, estamos usando el paso por valor, es decir
//estamos cambiando el valor de la variable, pero sin utilizar la referencia en memoria
//En la segunda funcion, el caracter & en el argumento nos indica que vamos a usar paso por referencia
//y aqui si que se modifica el valor en la referencia en memoria sin necesidad de volver a escribir otra variable