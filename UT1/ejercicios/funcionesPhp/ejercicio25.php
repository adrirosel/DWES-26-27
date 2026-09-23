<?php

declare(strict_types=1);

function esLargo(int $numPaginas):bool{
    if($numPaginas > 500) return true;
    return false;
}

//Si se invoca con una cadena de texto, daria error puesto que no se corresponde
//el tipo cadena que se pasa por argumento con el tipo entero que viene predefinido en 
//la declaracion de la funcion