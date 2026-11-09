<?php

declare(strict_types=1);

namespace AdrianRosel\Biblioteca\Repositorio;

use AdrianRosel\Biblioteca\Modelo\Libro;
use AdrianRosel\Biblioteca\Repositorio\LibroRepository;

class ArrayLibroRepository implements LibroRepository{
    public function __construct(private array $libros = [])
    {
        $this->libros = [];
        $id = 1;
        foreach($libros as $libro){
            $this->libros[$id] = $libro;
            $id++;
        }
    }

    public function todos(): array
    {
        return $this->libros;
    }

    public function buscarPorId(int $id): ?Libro
    {
        return $this->libros[$id] ?? null;
    }

    public function guardar(Libro $libro): int{
        if($this->libros === []){
            $nuevoId = 1;
        } else {
            $nuevoId = max(array_keys($this->libros)) + 1;
        }
        $this->libros[$nuevoId] = $libro;
        return $nuevoId;
    }


    public function actualizar(int $id, Libro $libro): void
    {
        if (!array_key_exists($id, $this->libros)) {
            throw new \OutOfBoundsException('Libro no encontrado');
        }

        $this->libros[$id] = $libro;
    }
}