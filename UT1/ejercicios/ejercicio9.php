<?php
$titulo = " El nombre del viento ";
//Eliminar espacios exteriores
$tituloTrim = trim($titulo);
echo $tituloTrim;

//Longitud

$longitud = strlen($tituloTrim);

echo "<br> La cadena tiene $longitud caracteres <br>";

//Comprobar si tiene la palabra "viento"

str_contains($tituloTrim, "viento");

//Sustituir viento por fuego

$nuevoTitulo = str_replace("viento", "fuego", $tituloTrim);

$tituloSeparado = explode(" ", $nuevoTitulo);

foreach($tituloSeparado as $palabra){
    echo $palabra . '<br>';
}