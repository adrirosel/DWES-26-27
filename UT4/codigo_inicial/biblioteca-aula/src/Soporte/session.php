<?php

declare(strict_types=1);

namespace App\Soporte;

function iniciarSesion(): void
{
    session_name('biblioteca');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    // session_set_cookie_params([
    //     'lifetime' => 0,
    //     'path' => '/',
    //     'secure' => true,
    //     'httponly' => true,
    //     'samesite' => 'Lax',
    // ]);
    session_start([
        'cookie_path' => '/',
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'cookie_secure' => false
    ]);
    if (!session_start()) {
        throw new \RuntimeException('Error de sesión');
    }
}
