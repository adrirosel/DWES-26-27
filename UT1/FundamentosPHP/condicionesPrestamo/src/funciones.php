<?php

declare(strict_types=1);

function filtrarTipo(string &$tipo): void{
    if($tipo === 'alumno') $tipo = $_GET['alumno'];
    if($tipo === 'profesor') $tipo = $_GET['profesor'];
    if($tipo === 'externo') $tipo = $_GET['externo'];
}

function comprobarParametroDias(string &$dias): void{
    try {
    $dias =  (int) $dias;
    if(!$dias >= 0)
        throw new Exception('Los dias tienen que ser mayores o iguales a 0');
    } catch (\Throwable $th) {
        echo $th->getMessage();
    }
}

function tieneRenovacion(string $tipo, string $renovacion, int &$dias):void{
    if($renovacion === 'si'){
        if($tipo === 'alumno' || $tipo === 'profesor') $dias += 7;

    }
}