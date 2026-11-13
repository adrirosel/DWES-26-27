<?php

declare(strict_types=1);

use App\Contrato\PeliculaRepository;
use App\Modelo\Pelicula;
use App\Servicio\ConsultaPelicula;
use PHPUnit\Framework\TestCase;

final class ConsultaPeliculaTest extends TestCase
{
    // COMPLETAR 11. Película ausente con un stub.
    public function testPeliculaAusenteConStub(): void{
        $repo = $this->createStub(PeliculaRepository::class);
        $repo->method('buscarPorId')->willReturn(null);

        $servicio = new ConsultaPelicula($repo);
        $this->expectException(OutOfBoundsException::class);

        $servicio->obtener(99);
    }


    // COMPLETAR 12. Consulta única del identificador con un mock.
    public function testConsultaIdConMock(): void{
        $pelicula = new Pelicula('Cartman baja de peso', 'Adrian Rosel', 155, 'terror');
        $repo = $this->createMock(PeliculaRepository::class);

        $repo->expects($this->once())->method('buscarPorId')->with(7)->willReturn($pelicula);

        $servicio = new ConsultaPelicula($repo);

        $this->assertSame($pelicula, $servicio->obtener(7));
    }

}
