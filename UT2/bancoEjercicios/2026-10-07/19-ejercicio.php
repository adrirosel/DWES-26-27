<?php

declare(strict_types=1);

function validarCodigo(string $codigo): int|false{
    return preg_match('/^LIB-\d{4}-\d{4}$/', $codigo);
}

$codigo1 = validarCodigo('LIB-2026-0042');
$codigo2 = validarCodigo('LIB-2026-004299');
$codigo3 = preg_match('/^zLIB-d{4-\d{4}$/', 'lkjshlskjh');

var_dump($codigo1);
var_dump($codigo2);
var_dump($codigo3);