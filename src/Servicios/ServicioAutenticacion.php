<?php

namespace App\Servicios;

use App\Nucleo\Sesion;
use App\Repositorios\RepositorioUsuarios;

class ServicioAutenticacion
{
    private const MAX_INTENTOS = 5;
    private const BLOQUEO_SEGUNDOS = 300;

    private const HASH_FALSO = '$2y$12$ju3DL/qhaa8iFgB9nHfyg.93unQgEnd2AQRXN1xdnHbA/4jovKYMO';

    public static function login(string $numeroCuenta, string $clave): array
    {
        $ahora = time();

        $bloqueoHasta = (int) ($_SESSION['bloqueo_hasta'] ?? 0);
        if ($bloqueoHasta > $ahora) {
            $minutos = (int) ceil(($bloqueoHasta - $ahora) / 60);
            return ['exito' => false, 'mensaje' => "Demasiados intentos fallidos. Espera $minutos minuto(s)."];
        }

        $usuario = RepositorioUsuarios::buscarPorNumeroCuenta(trim($numeroCuenta));

        $claveValida = password_verify($clave, $usuario?->clave_hash ?? self::HASH_FALSO);

        if ($usuario === null || !$claveValida) {
            $_SESSION['intentos'] = (int) ($_SESSION['intentos'] ?? 0) + 1;

            if ($_SESSION['intentos'] >= self::MAX_INTENTOS) {
                $_SESSION['bloqueo_hasta'] = $ahora + self::BLOQUEO_SEGUNDOS;
                $_SESSION['intentos'] = 0;
            }

            return ['exito' => false, 'mensaje' => 'Número de cuenta o contraseña incorrectos.'];
        }

        unset($_SESSION['intentos'], $_SESSION['bloqueo_hasta']);
        Sesion::iniciarSesionCuenta($usuario->cuenta_id);

        return ['exito' => true, 'mensaje' => ''];
    }
}
