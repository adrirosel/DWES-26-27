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
$RETRASO_LEVE = 3;
$RETRASO_GRAVE = 9;

function clasificarSituacion(int $diasSegunTipo): void{
    global $RETRASO_LEVE;
    global $RETRASO_GRAVE;
    if($diasSegunTipo < $RETRASO_LEVE){
        echo "Correcta";
    } else if($diasSegunTipo === $RETRASO_LEVE){
        echo 'Ultimo dia';
    } else if($diasSegunTipo >= $RETRASO_LEVE || $diasSegunTipo <= $RETRASO_GRAVE ){
        echo 'Retraso leve';
    } else {
        echo 'Retraso grave';
    }
}

function calcularPenalizacion(int $dias, int|null $diasSegunTipo, float &$penalizacion): float{
    $diasExactosRetraso = $dias - $diasSegunTipo;
    return $diasExactosRetraso * $penalizacion;
}

function listarDiasDeRetraso(): void{
    $diasRetraso = 100;
    for($i = 1; $i <= $diasRetraso; $i++){
        echo "Dia $i"; 
        if($i > 10){
            echo "...";
            break;
        }
    }
}