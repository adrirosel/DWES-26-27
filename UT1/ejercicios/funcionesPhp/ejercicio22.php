<?php

declare(strict_types=1);

function calcularFechaPrestamo(int $dias = 15):int{
    return $dias;
}

calcularFechaPrestamo(20); //Devuelve 20
calcularFechaPrestamo(); //Devuelve 15 (Valor por defecto)