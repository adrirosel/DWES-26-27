<?php

declare(strict_types=1);

namespace AdrianRosel\Biblioteca\Modelo;
use AdrianRosel\Biblioteca\Modelo\Libro;


final class LibroDigital extends Libro{

    public function tipo(): string
    {
        return 'digital';
    }

    public function costeReparacionCentimos(): int
    {
        return 400 * $this->unidades();
    }
}