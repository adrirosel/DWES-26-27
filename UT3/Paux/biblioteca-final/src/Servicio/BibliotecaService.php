<?php

declare(strict_types=1);

namespace AdrianRosel\Biblioteca\Servicio;

use AdrianRosel\Biblioteca\Repositorio\LibroRepository;
use AdrianRosel\Biblioteca\Repositorio\ArrayLibroRepository;
use AdrianRosel\Biblioteca\Modelo\Libro;
use OutOfBoundsException;

final class BibliotecaService{
    public function __construct(private LibroRepository $repo)
    {
    }
    public function prestar(int $id): void{
        $libroDeseado = $this->repo->buscarPorId($id);
        if(is_null($libroDeseado)){
            throw new \OutOfBoundsException('Libro no encontrado');
        }
        $libroDeseado->prestar();
    }
    public function devolver(int $id): void{
        $libroDeseado = $this->repo->buscarPorId($id);
        if(is_null($libroDeseado)){
            throw new \OutOfBoundsException('Libro no encontrado');
        }
        $libroDeseado->devolver();
    }
    public function filtrar(
        string $q, 
        string $genero, 
        string $tipo, 
        bool $soloDestacados
    ): array{
        $texto = mb_strtolower(trim($q));
        $genero = trim($genero);
        $tipo = trim($tipo);
        return array_filter(
            $this->repo->todos(), 
            fn(Libro $l): bool =>
                ($texto === '' || (str_contains($l->titulo(), $texto) || str_contains($l->autor(), $texto))) &&
                ($genero === '' || $l->genero() === $genero) &&
                ($tipo === '' || $l->tipo() === $tipo) &&
                (!$soloDestacados || $l->destacado())
        );
    }
    public function filas(array $libros): array{
        if($libros === []) return [];
        return array_map(
        function (Libro $libro, int $id): array {
            $fechaAlta = $libro->fechaAlta();

            return [
                'id' => $id,
                'titulo' => $libro->titulo(),
                'autor' => $libro->autor(),
                'paginas' => $libro->paginas(),
                'genero' => $libro->genero(),
                'tipo' => $libro->tipo(),
                'unidades' => $libro->unidades(),
                'fechaAlta' => $fechaAlta?->format('Y-m-d') ?? 'Sin fecha',
                'destacado' => $libro->destacado(),
                'observaciones' => $libro->observaciones(),
                'disponible' => $libro->estaDisponible(),
                'portada' => $libro->portada(),
            ];
        },
        $libros,
        array_keys($libros)
    );

    }
    public function resumen(array $libros): array{
        return array_reduce(
            $libros, 
            function(array $carry, Libro $item): array{
                $carry['titulos']++;
                $carry['unidades'] += $item->unidades();
                $carry['paginas'] += $item->paginas();
                $carry['costeCentimos'] += $item->costeReparacionCentimos();
                return $carry;
            },
            ['titulos' => 0, 'unidades' => 0, 'paginas' => 0, 'costeCentimos' => 0]
        );
    }
}