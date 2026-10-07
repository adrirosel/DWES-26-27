<?php

declare(strict_types=1);

$codigo = 'LIB-2026-0042';

$prefijo = substr($codigo, 0, 3);

print_r($prefijo);
echo '<br>';

$sufijo = substr($codigo, 9, 4);
print_r($sufijo);

$dracula = 'Drácula';

$prefijoDra = mb_substr($dracula, 0, 3, 'UTF-8');
echo '<br>';
var_dump($prefijoDra);

//Para este caso es mejor usar mb_, nos permite distinguir entre tildes
//mediante la codificación UTF-8