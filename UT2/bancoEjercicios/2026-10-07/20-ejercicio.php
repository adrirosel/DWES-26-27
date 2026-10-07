<?php

declare(strict_types=1);

$cadena = "    ESTO     Es    
     Una CADENA      SIN    normalizar    palabra con tílde";



$cadenaNormalizada = mb_strtolower(preg_replace('/\s+/', ' ', $cadena), 'UTF-8');

var_dump($cadenaNormalizada);