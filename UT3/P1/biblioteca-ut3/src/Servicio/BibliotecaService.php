<?php

declare(strict_types=1);

namespace AdrianRosel\Biblioteca\Servicio;
use AdrianRosel\Biblioteca\Modelo\Libro;

class BibliotecaService {
    public function __construct(private array $libros){}

    public function todos(): array {
        return $this->libros;
    }
    public function agregar(Libro $libro): void {
        $libros[] = $libro;
    }
    public function filtrar(
        string $q, string $genero, string $tipo,
        bool $soloDestacados
    ): array {
        $texto = self::normalizar($q);

        return array_filter(
            $this->todos(), 
            fn(Libro $l): bool => 
                (str_contains($l->titulo(), $texto) || str_contains($l->autor(), $texto)) &&
                ($genero === '' || $l->genero() === $genero) &&
                ($tipo === '' || $l->getTipo() === $tipo) &&
                (!$soloDestacados || $soloDestacados && $l->destacado())
        );

    }
    public function filas(array $libros): array {
        return array_map(
            fn(Libro $l): array=> [
                'titulo' => $l->titulo(),
                'autor' => $l->autor(),
                'paginas' => $l->paginas(),
                'genero' => $l->genero(), 
                'tipo' => $l->getTipo(),
                'unidades' => $l->unidades(),
                'fechaAlta' => $l->fechaAlta()->format('Y-m-d') ?? 'Sin fecha',
                'destacado' => $l->observaciones(),
                'costeCentimos' => $l->costeReposicionCentimos()
            ], 
            $libros
        );
    }
    public function resumen(array $libros): array {
        return array_reduce(
            $libros, 
            function(array $carry, Libro $item){
                $carry['titulos']++;
                $carry['unidades'] += $item->unidades();
                $carry['paginas'] += $item->paginas();
                $carry['costeCentimos'] += $item->costeReposicionCentimos();
                return $carry;
            }, 
            ['titulos' => 0, 'unidades' => 0, 'paginas' => 0, 'costeCentimos' => 0]
        );
    }
    private static function normalizar(string $texto): string{
        return mb_strtolower(trim($texto), 'UTF-8');
    }
}