<?php

declare(strict_types=1);

namespace AdrianRosel\Biblioteca\Modelo;
use AdrianRosel\Biblioteca\Modelo\Libro;


class LibroDigital extends Libro{
    
    public function getTipo(): string
    {
        return 'digital';
    }
    
    public function costeReposicionCentimos(): int
    {
        return $this->unidades() * 400;
    }
}