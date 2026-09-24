<?php
// Escribe un if/elseif/else que reciba días de retraso
// y muestre: //«Sin retraso» si es 0; «Retraso leve»
// entre 1 y 7; «Retraso grave» entre 8 y 30; «Bloqueo temporal» si supera 30.

$diasRetraso = 31;
if($diasRetraso === 0){
    echo 'Sin retraso';
}else if($diasRetraso >= 1 && $diasRetraso <=7){
    echo 'Retraso leve';
} else if($diasRetraso <=30){
    echo 'Retraso grave';
} else {
    echo 'Bloqueo temporal';
}