<?php

declare(strict_types=1);

namespace AdrianRosel\Biblioteca\Repositorio;
use AdrianRosel\Biblioteca\Modelo\Libro;

interface LibroRepository{
    public function todos(): array;
    public function buscarPorId(int $id): ?Libro;
    public function guardar(Libro $libro): int;
    public function actualizar(int $id, Libro $libro): void;
}