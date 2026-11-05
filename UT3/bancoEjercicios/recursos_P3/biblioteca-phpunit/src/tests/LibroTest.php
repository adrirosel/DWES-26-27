<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Model\Libro;
use App\Model\LibroNoDisponibleException;

final class LibroTest extends TestCase{
    //Ej22. 
    public function testConservaTitulo(): void{
        $libro = new Libro('Dune', 'Frank Herbert', 412);

        $this->assertSame('Dune', $libro->titulo());
    }
    //Ej23 
    public function testComprobarDisponibilidadYPáginas(): void {
        $libro2 = new Libro('Dune', 'Frank Herbert', 412);
        $libro2->prestar();
        $estaDisponible = $libro2->estaDisponible();
        $this->assertFalse($estaDisponible);

        //$this->assertSame($libro2->paginas(), '412');
        $this->assertEquals($libro2->paginas(), '412');
    }
    //Ej24
    public function testComprobarExcepcion(): void{
        $libro3 = new Libro('Dune', 'Frank Herbert', 412);
        $libro3->prestar();
        $this->expectException(LibroNoDisponibleException::class);
        $libro3->prestar();

        $libro4 = new Libro('', 'miau', 412);
        $libro5 = new Libro('miau', '', 412);
        $this->expectException(InvalidArgumentException::class);
    }

}