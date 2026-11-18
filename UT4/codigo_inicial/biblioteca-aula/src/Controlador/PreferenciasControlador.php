<?php

declare(strict_types=1);

namespace App\Controlador;

use function App\Soporte\redirigir;

final class PreferenciasControlador extends Controlador {
    public function guardar(): void {
        $tema = $_POST['tema'] ?? null;

        if(in_array($tema, ['claro', 'oscuro'], true)){
            //Guardar
            $this->guardarCookie('tema', $tema);
            //Redirigir
            redirigir('index.php');
        }
        http_response_code(400);
        exit;
    }

    public function guardarEspaciado(): void {
        $espaciado = $_POST['espaciado'] ?? null;

        if(in_array($espaciado, ['mayor', 'menor'])){
            $this->guardarCookie('espaciado', $espaciado);
            redirigir('index.php');
        }
        http_response_code(400);
        exit;
    }

    private function guardarCookie(string $cookie, string $valor): void {
        setcookie($cookie, $valor, [
            'expires' =>time() + 30 * 86400,
            'path' => '/', 
            'secure' => false, 
            'httponly' => true, 
            'samesite' => 'Lax'
        ]);
    }
}