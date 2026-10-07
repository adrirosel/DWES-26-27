<?php

declare(strict_types=1);

function mostrar(mixed $valor): string{
    if(is_null($valor)) return '';
    return is_bool($valor) ? 'bool('.$valor.')' : (string) $valor;
}

print_r(mostrar(true));
print_r(mostrar(42));
print_r(mostrar('Dune'));