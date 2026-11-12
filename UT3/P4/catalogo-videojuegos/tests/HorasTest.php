<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function App\Soporte\validarVideojuego;

final class HorasTest extends TestCase
{
    // COMPLETAR 9. Proveedor y prueba de los cinco valores de horas.
    public static function casosHoras(): array{
        return [
            ['1', true], 
            ['3000', true], 
            ['0', false], 
            ['3001', false], 
            ['12abc', false],
            [['412'], false]
        ];
    }
    #[DataProvider('casosHoras')]
    public function testCasosHoras(mixed $entrada, bool $valida): void{
        $post = $this->datosValidos();
        $post['horas'] = $entrada;
        $r = validarVideojuego($post);
        $this->assertSame($valida, !isset(['errores']['datos']));
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
