<?php

declare(strict_types=1);

use PHPUnit\Event\Runtime\Runtime;
use PHPUnit\Framework\TestCase;

use function App\Soporte\inspeccionarCaratula;

final class CaratulaTemporalTest extends TestCase
{
    private ?string $temporal = null;

    // COMPLETAR 10. setUp, prueba de rechazo y tearDown.
    
    protected function setUp(): void
    {
        $ruta = tempnam(sys_get_temp_dir(), 'ut3_');
        if($ruta === false){
            throw new RuntimeException('No se ha podido crear el archivo temporal');
        }
        $this->temporal = $ruta;
        file_put_contents($this->temporal, 'Texto no vacío');
    }

    public function testComprobarCaratula(): void {
        $caratula = inspeccionarCaratula($this->entradaArchivo());
        $this->assertNull($caratula['archivo']);
        $this->assertNotNull($caratula['error']);
    }
    
    protected function tearDown(): void
    {
        if($this->temporal !== null && is_file($this->temporal)){
            unlink($this->temporal);
        }
        $this->assertFileDoesNotExist($this->temporal);
    }


    // Proporcionado. Representa el temporal como entrada de inspeccionarCaratula.
    private function entradaArchivo(): array
    {
        if ($this->temporal === null || !is_file($this->temporal)) {
            throw new RuntimeException('El temporal de prueba no está preparado.');
        }

        return [
            'caratula' => [
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($this->temporal),
                'tmp_name' => $this->temporal,
            ],
        ];
    }
}
