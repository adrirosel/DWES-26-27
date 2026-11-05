<?php

declare(strict_types=1);

namespace AdrianRosel\Biblioteca\Modelo;

use AdrianRosel\Biblioteca\Modelo\Libro;

final class LibroPapel extends Libro{

    public function tipo(): string
    {
        return 'papel';
    }

    public function costeReparacionCentimos(): int
    {
        return $this->paginas() * 5 * $this->unidades();
    }
}