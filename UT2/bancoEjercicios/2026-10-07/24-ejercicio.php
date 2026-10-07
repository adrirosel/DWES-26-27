<?php

declare(strict_types=1);

function normalizarId(int|string $id): int{
    return is_string($id) ? (int) $id : $id;
}

var_dump(normalizarId(5));
echo '<br>';

var_dump(normalizarId('5'));
echo '<br>';


function normalizarEtiqueta(?string $titulo): string{
    return is_null($titulo) ? 'Valor invalido' : $titulo;
}

var_dump(normalizarEtiqueta('Dune'));
echo '<br>';

var_dump(normalizarEtiqueta(null));
echo '<br>';