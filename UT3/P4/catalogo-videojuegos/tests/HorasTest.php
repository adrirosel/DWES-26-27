<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function App\Soporte\validarVideojuego;

final class HorasTest extends TestCase
{
    // COMPLETAR 9. Proveedor y prueba de los cinco valores de horas.
    public static function casosHoras(): array {
        return [
            ['1', true],
            ['300', true],
            ['0', false],
            ['301', false],
            ['12abc', false]
        ];
    }

    #[DataProvider('casosHoras')]
    public function testComprobarCasosHoras(mixed $entrada, bool $valida): void{
        $copia = $this->datosValidos();
        $copia['horas'] = $entrada;
        $videojuego = validarVideojuego($copia);

        $this->assertSame($valida, !isset($videojuego['errores']['horas']));
        if($valida){
            $this->assertSame( (int)$entrada, $videojuego['datos']['horas']);
            $this->assertIsInt($videojuego['datos']['horas']);
        } else {
            $this->assertNull($videojuego['datos']);
        }
    }


    // Proporcionado. Datos válidos sobre los que varías solo horas.
    private function datosValidos(): array
    {
        return [
            'titulo' => 'Islas de cristal',
            'estudio' => 'Nébula Studio',
            'horas' => '35',
            'genero' => 'aventura',
            'fechaLanzamiento' => '',
        ];
    }
}
