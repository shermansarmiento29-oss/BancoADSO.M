<?php

namespace App\Nucleo;

final class Vista
{

    public static function render(string $vista, array $datos = []): void
    {
        $e = static fn ($valor): string => htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
        $moneda = static fn ($n): string => '$' . number_format((float) $n, 2, ',', '.');
        $campoCsrf = Csrf::campo();
        $flash = Sesion::tomarFlash();

        extract($datos, EXTR_SKIP);

        require __DIR__ . '/../../vistas/' . $vista . '.php';
    }
}
