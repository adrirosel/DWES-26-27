<?php

declare(strict_types=1);

use App\Contrato\VideojuegoRepository;
use App\Modelo\Videojuego;
use App\Servicio\ConsultaVideojuego;
use PHPUnit\Framework\TestCase;

final class ConsultaVideojuegoTest extends TestCase
{
    // COMPLETAR 11. Videojuego ausente con un stub.
    public function testVideojuegoAusenteConStub(): void {
        $repo = $this->createStub(VideojuegoRepository::class);
        $repo->method('buscarPorId')->willReturn(null);

        $servicio = new ConsultaVideojuego($repo);
        $this->expectException(OutOfBoundsException::class);

        $servicio->obtener(99);
    }


    // COMPLETAR 12. Consulta única del identificador con un mock.
    public function testConsultarIdConMock(): void {
        $videojuego = new Videojuego('Torre de cartón', 'Factor Games', 19, 'estrategia');
        $repo = $this->createMock(VideojuegoRepository::class);
        $repo->expects($this->once())->method('buscarPorId')->with(7)->willReturn($videojuego);

        $servicio = new ConsultaVideojuego($repo);

        $videojuego2 = $servicio->obtener(7);

        $this->assertSame($videojuego, $videojuego2);
    }

}
