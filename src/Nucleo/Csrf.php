<?php

namespace App\Nucleo;

final class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    public static function campo(): string
    {
        return '<input type="hidden" name="csrf" value="' . self::token() . '">';
    }

    public static function validar(mixed $token): bool
    {
        return isset($_SESSION['csrf'])
            && is_string($token)
            && hash_equals($_SESSION['csrf'], $token);
    }
}
