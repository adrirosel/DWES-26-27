<?php
$a = (5 == "5"); //True
$b = (5 === "5"); // False
$c = (10 > 5 && 3 < 2); //True, ya que se cumplen las dos condiciones
$d = !$b || $c; //True, en este caso los dos valores de la comparacion son true

//La principal diferencia entre "==" y "===" reside en que el primer comparador
//comprueba unicamente el valor de los dos elementos, mientras que 
//el segundo comparador comprueba tambien la IDENTIDAD, es decir, el tipo de dato

