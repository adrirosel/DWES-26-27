<?php

declare(strict_types=1);

use App\Modelo\Videojuego;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertIsInt;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class CatalogoTest extends TestCase
{
    // COMPLETAR 8. Creación válida y estado del objeto.
    public function testCreacionValida(): void{
        $videojuego = new Videojuego(' Islas de cristal ', 'Nébula Studio ', 35, 'aventura');
        $this->assertSame(trim($videojuego->titulo()), $videojuego->titulo());
        $this->assertSame(trim($videojuego->estudio()), $videojuego->estudio());

        $this->assertSame(35, $videojuego->horas());

        $this->assertNull($videojuego->fechaLanzamiento(), 'Los resultados en la fecha no coinciden');

    }
}
