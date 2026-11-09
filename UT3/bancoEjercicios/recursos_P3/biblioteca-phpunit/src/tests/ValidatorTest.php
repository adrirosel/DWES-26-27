<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Service\Validator;
use PHPUnit\Framework\Attributes\DataProvider;

final class ValidatorTest extends TestCase
{
    public static function titulosVacios(): array
    {
        return [
            'vacío' => [''],
            'espacios' => [' '],
            'tabulación' => ["\t"],
        ];
    }
    #[DataProvider('titulosVacios')]
    public function testTituloRequerido(string $titulo): void{
        $v = new Validator();
        $this->assertSame('Escribe el titulo.', $v->requerido($titulo, 'Escribe el titulo.'));

        $this->assertSame(null, $v->requerido('Dune', 'Escribe el titulo'));
    }
}
