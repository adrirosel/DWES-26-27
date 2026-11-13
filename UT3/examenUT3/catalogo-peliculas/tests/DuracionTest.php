<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function App\Soporte\validarPelicula;

final class DuracionTest extends TestCase
{
    // COMPLETAR 9. Proveedor y prueba de las cinco duraciones.
    public static function duraciones(): array {
        return [
            ['1', true],
            ['300', true], 
            ['0', false], 
            ['301', false], 
            ['12abc', false]
        ];
    }
    #[DataProvider("duraciones")]
    public function testDuraciones(mixed $entrada, bool $valida): void {
        $copia = $this->datosValidos();
        $copia['duracion'] = $entrada;
        $copiaValidada = validarPelicula($copia);

        $this->assertSame($valida, !isset($copiaValidada['errores']['duracion']));
        if($valida){
            $this->assertSame((int)$entrada, $copiaValidada['datos']['duracion']);
        } else {
            $this->assertNull($copiaValidada['datos']);
        }
    }


    // Proporcionado. Datos válidos sobre los que varías solo duracion.
    private function datosValidos(): array
    {
        return [
            'titulo' => 'Dune',
            'director' => 'Denis Villeneuve',
            'duracion' => '155',
            'genero' => 'ciencia',
            'fechaEstreno' => '',
        ];
    }
}
