<?php

namespace App\Nucleo;

final class Sesion
{
    public static function iniciar(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'secure'   => !empty($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }
    }

    public static function cuentaId(): ?int
    {
        return isset($_SESSION['cuenta_id']) ? (int) $_SESSION['cuenta_id'] : null;
    }

    public static function iniciarSesionCuenta(int $cuentaId): void
    {
        session_regenerate_id(true);
        $_SESSION['cuenta_id'] = $cuentaId;
    }

    public static function cerrar(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }

        session_destroy();
    }

    public static function flash(string $tipo, string $texto): void
    {
        $_SESSION['flash'] = ['tipo' => $tipo, 'texto' => $texto];
    }

    public static function tomarFlash(): ?array
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }
}
