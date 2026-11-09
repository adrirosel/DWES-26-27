<?php

declare(strict_types=1);

namespace AdrianRosel\Biblioteca\Modelo;

use InvalidArgumentException;
use DateTimeImmutable;
use AdrianRosel\Biblioteca\Modelo\LibroNoDisponibleException;
abstract class Libro{
    private bool $disponible = true;
    private ?string $portada = null;
    public function __construct(
        private string $titulo, 
        private string $autor,
        private int $paginas, 
        private string $genero, 
        private int $unidades, 
        private ?DateTimeImmutable $fechaAlta = null, 
        private bool $destacado = false, 
        private string $observaciones = ''
    ){
        if(trim($this->titulo()) === '' || trim($this->autor())=== ''){
            throw new InvalidArgumentException('Argumento no especificado obligatorio');
        }
        if(strlen(trim($this->titulo())) <= 0 || strlen(trim($this->titulo())) > 120){
            throw new InvalidArgumentException('El titulo debe de contener de 1 a 120 caracteres');
        }
        if(strlen(trim($this->autor())) <= 0 || strlen(trim($this->autor())) > 100){
            throw new InvalidArgumentException('El autor debe de contener de 1 a 100 caracteres');
        }
        if($this->paginas() <=0 || $this->paginas() > 3000){
            throw new InvalidArgumentException('El número de páginas debe de ser entre 1 y 3000, ambos incluidos');
        }
        if(!in_array($this->genero(), ['ciencia', 'fantasia', 'terror'])){
            throw new InvalidArgumentException('Género no valido');
        }
        if($this->unidades() < 1 || $this->unidades() > 50){
            throw new InvalidArgumentException('Las unidades deben de contemplarse entre 1 y 50');
        }
        if(strlen(trim($this->observaciones())) > 300){
            throw new InvalidArgumentException('Máximo de 300 caracteres');
        }

    }
    public function titulo(): string{
        return $this->titulo;
    }   
    public function autor(): string{
        return $this->autor;
    }
    public function paginas(): int{
        return $this->paginas;
    }
    public function genero(): string{
        return $this->genero;
    }
    public function unidades(): int{
        return $this->unidades;
    }
    public function fechaAlta(): ?DateTimeImmutable{
        return $this->fechaAlta;
    }
    public function destacado(): bool{
        return $this->destacado;
    }
    public function observaciones(): string{
        return $this->observaciones;
    }
    public function estaDisponible(): bool{
        return $this->disponible;
    }
    public function portada(): ?string{
        return $this->portada;
    }
    public function prestar():void{
        if(!$this->estaDisponible()){
            throw new LibroNoDisponibleException('El libro no está disponible');
        }
        $this->disponible = false;
    }
    public function devolver(): void{
        if($this->estaDisponible()){
            throw new LibroNoDisponibleException('El libro no estaba prestado anteriormente');
        }
        $this->disponible = true;
    }
    public function cambiarPortada(?string $nombre): void{
        if($nombre !== null && preg_match('/^[a-f0-9]{32}\.(jpg|webp|png)$/', $nombre) !== 1){
            throw new InvalidArgumentException('Formato de nombre no valido');
        }
        $this->portada = $nombre;
    }
    public function actualizarDatos(
        string $titulo, 
        string $autor, 
        int $paginas, 
        string $genero, 
        int $unidades, 
        ?DateTimeImmutable $fechaAlta = null, 
        bool $destacado = false, 
        string $observaciones = ''
    ){
        if(trim($titulo) === '' || trim($autor)=== ''){
            throw new InvalidArgumentException('Argumento no especificado obligatorio');
        }
        if(strlen(trim($titulo)) <= 0 || strlen(trim($titulo)) > 120){
            throw new InvalidArgumentException('El titulo debe de contener de 1 a 120 caracteres');
        }
        if(strlen(trim($autor))<=0 || strlen(trim($autor))>100){
            throw new InvalidArgumentException('El autor debe de contener entre 1 y 100 caracteres');
        }
        if($paginas <=0 || $paginas > 3000){
            throw new InvalidArgumentException('El número de páginas debe de ser entre 1 y 3000, ambos incluidos');
        }
        if(!in_array($genero, ['ciencia', 'fantasia', 'terror'])){
            throw new InvalidArgumentException('Género no valido');
        }
        if($unidades < 1 || $unidades > 50){
            throw new InvalidArgumentException('Las unidades deben de contemplarse entre 1 y 50');
        }
        if(strlen(trim($observaciones)) > 300){
            throw new InvalidArgumentException('Máximo de 300 caracteres');
        }
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->paginas = $paginas;
        $this->genero = $genero;
        $this->unidades = $unidades;
        $this->fechaAlta = $fechaAlta;
        $this->destacado = $destacado;
        $this->observaciones = $observaciones;
    }
    abstract public function tipo(): string;
    abstract public function costeReparacionCentimos(): int;

}