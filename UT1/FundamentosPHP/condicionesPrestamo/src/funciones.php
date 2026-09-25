<?php

declare(strict_types=1);

function filtrarTipo(string &$tipo): void{
    if($tipo === 'alumno') $tipo = $_GET['alumno'];
    if($tipo === 'profesor') $tipo = $_GET['profesor'];
    if($tipo === 'externo') $tipo = $_GET['externo'];
}

function comprobarParametroDias(string &$dias): void{
    $dias = (int) $dias;
    if($dias < 0){
        echo 'Parametro no valido';
    }
}

function tieneRenovacion(string $tipo, string $renovacion, int &$diasSegunTipo):void{
    if($renovacion === 'si'){
        if($tipo === 'alumno' || $tipo === 'profesor') $diasSegunTipo += 7;
    }
}
$retrasoLeve = 3;
$retrasoGrave = 9;

function clasificarSituacion(int $diasSegunTipo): void{
    global $retrasoLeve;
    global $retrasoGrave;
    if($diasSegunTipo < $retrasoLeve){
        echo "Correcta";
    } else if($diasSegunTipo === $retrasoLeve){
        echo 'Ultimo dia';
    } else if($diasSegunTipo >= $retrasoLeve || $diasSegunTipo <= $retrasoGrave ){
        echo 'Retraso leve';
    } else {
        echo 'Retraso grave';
    }
}

function calcularPenalizacion(int $dias, int|null $diasSegunTipo, float &$penalizacion): float{
    $diasExactosRetraso = $dias - $diasSegunTipo;
    return $diasExactosRetraso * $penalizacion;
}