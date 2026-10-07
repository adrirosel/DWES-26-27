<?php

declare(strict_types=1);

//Saber si aparece una palabra

//Utilizaria str_contains(), esta funcion comprueba si dentro de 
//una cadena se encuentra una cadena solicitada

//Conocer su posicion

//Usaremos strpos(), esta funcion averigua el caracter exacto
//donde se encuentra la palabra
//Caracter se refiere a, contando desde el principio 1 a 1, la posicion

//Comprobar un prefijo/sufijo

//Para los dos casos podemos usar substr o mb_substr; 
//esta función extrae partes de una cadena mas larga

//Validar un formato con patrón

//Usaremos preg_match. Esta función nos permite saber si un codigo
//sigue un patrón definido

//Sustituir espacios repetidos

//Para este caso combiene más usar preg_replace(), ya que 
//nos permite sustiuir espacios repetidos indeseados mediante un patrón

//Trabajar con texto UTF-8

//Si queremos tener en cuenta la codificación de las cadenas de texto, 
// el prefijo "mb_" delante de la función nos da la utilidad de indicar la
//codificación que va a regir una cadena de texto
