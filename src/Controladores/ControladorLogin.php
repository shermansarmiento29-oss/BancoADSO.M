<?php

namespace App\Controladores;

use App\Nucleo\Csrf;
use App\Nucleo\Router;
use App\Nucleo\Sesion;
use App\Nucleo\Vista;
use App\Servicios\ServicioAutenticacion;

class ControladorLogin
{
    public function mostrarLogin(): void
    {
        if (Sesion::cuentaId() !== null) {
            Router::redirigir('panel');
        }

        Vista::render('login');
    }

    public function procesarLogin(): void
    {
        if (!Csrf::validar($_POST['csrf'] ?? null)) {
            Sesion::flash('error', 'El formulario expiró. Inténtalo de nuevo.');
            Router::redirigir('login');
        }

        $numeroCuenta = is_string($_POST['numero_cuenta'] ?? null) ? $_POST['numero_cuenta'] : '';
        $clave = is_string($_POST['clave'] ?? null) ? $_POST['clave'] : '';

        $resultado = ServicioAutenticacion::login($numeroCuenta, $clave);

        if ($resultado['exito']) {
            Router::redirigir('panel');
        }

        Sesion::flash('error', $resultado['mensaje']);
        Router::redirigir('login');
    }

    public function cerrarSesion(): void
    {
        Sesion::cerrar();
        Router::redirigir('login');
    }
}
