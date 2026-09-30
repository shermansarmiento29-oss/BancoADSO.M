<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controladores\ControladorBanco;
use App\Controladores\ControladorLogin;
use App\Nucleo\Router;
use App\Nucleo\Sesion;

Sesion::iniciar();

$router = new Router();

$router->registrar('login',                    ControladorLogin::class, 'mostrarLogin');
$router->registrar('procesar-login',           ControladorLogin::class, 'procesarLogin', 'POST');
$router->registrar('logout',                   ControladorLogin::class, 'cerrarSesion');

$router->registrar('panel',                    ControladorBanco::class, 'mostrarPanel');
$router->registrar('retiro',                   ControladorBanco::class, 'mostrarRetiro');
$router->registrar('procesar-retiro',          ControladorBanco::class, 'procesarRetiro', 'POST');
$router->registrar('transferencia',            ControladorBanco::class, 'mostrarTransferencia');
$router->registrar('procesar-transferencia',   ControladorBanco::class, 'procesarTransferencia', 'POST');
$router->registrar('historial-retiros',        ControladorBanco::class, 'mostrarHistorialRetiros');
$router->registrar('historial-transferencias', ControladorBanco::class, 'mostrarHistorialTransferencias');

$ruta = $_GET['ruta'] ?? 'login';
$router->despachar(is_string($ruta) ? $ruta : 'login');
