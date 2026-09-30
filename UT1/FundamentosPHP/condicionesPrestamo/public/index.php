<?php

declare(strict_types=1);
require_once __DIR__ . '/../src/funciones.php';

$tipo = $_GET['tipo'] ?? 'todos';
//Hay varios valores posibles para el tipo, asi que clasifico en funcion de cual podria ser
//Nos aseguramos de que se pasa una cadena de texto
if(is_string($tipo)){
    filtrarTipo($tipo);
}

$dias = $_GET['dias'] ?? 0;

//Al llamar al metodo se hace el casting a entero y comprueba que los dias sean positivos
comprobarParametroDias($dias);

$renovacion = $_GET['renovacion'] ?? 'no';

//Asignar maximo de dias por tipo

$diasSegunTipo = match ($tipo) {
     'alumno' => 15,
     'profesor' => 30 ,
     'externo' => 7,      
};
     //La funcion comprueba si hay renovacion
    tieneRenovacion($tipo, $renovacion, $diasSegunTipo);

//Clasificar situacion de retraso

clasificarSituacion($diasSegunTipo);

//Aplicar penalizacion

$penalizacion = 0.50;
calcularPenalizacion($dias, $diasSegunTipo, $penalizacion);

// Frase usando concatenacion

echo 'El usuario'. htmlspecialchars($tipo).' tiene un limite de' . $diasSegunTipo . 
'dias antes de que se le empiece a aplicar una tarifa de ' . $penalizacion . '$ por dia de retraso';

//Lista de los dias de retraso

listarDiasDeRetraso();

 