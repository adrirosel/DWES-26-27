<?php
/*
Completa el programa para escribir los números del 1 
al 30 excepto los múltiplos de 5. El bucle debe
detenerse completamente al llegar a 26.

*/
for ($i = 1; $i <= 30; $i++) {
 if ( $i % 5 === 0) {
 continue;
 }
 if ($i === 26) {
 break;
 }
 echo $i . PHP_EOL;
}