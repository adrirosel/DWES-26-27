<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use function App\Soporte\inspeccionarCartel;

final class CartelTemporalTest extends TestCase
{
    private ?string $temporal = null;

    // COMPLETAR 10. setUp, prueba de rechazo y tearDown.

    protected function setUp(): void
    {
        $archivo = tempnam(sys_get_temp_dir(), 'ut3_');
        if($archivo === false){
            throw new RuntimeException('No ha sido posible crear el temporal');
        }
        $this->temporal = $archivo;
        file_put_contents($this->temporal, 'Texto no vacío');
    }

    public function testComprobarDatosArchivo(): void{
        $r = inspeccionarCartel($this->entradaArchivo());
        $this->assertNull($r['archivo']);
        $this->assertNotNull($r['error']);
    }

    protected function tearDown(): void
    {
        if($this->temporal !== null && is_file($this->temporal)){
            unlink($this->temporal);
        }
        $this->assertFileDoesNotExist($this->temporal);
    }

    // Proporcionado. Representa el temporal como entrada de inspeccionarCartel.
    private function entradaArchivo(): array
    {
        if ($this->temporal === null || !is_file($this->temporal)) {
            throw new RuntimeException('El temporal de prueba no está preparado.');
        }

        return [
            'cartel' => [
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($this->temporal),
                'tmp_name' => $this->temporal,
            ],
        ];
    }
}
