<?php

namespace App\Controladores;

use App\Nucleo\Csrf;
use App\Nucleo\Router;
use App\Nucleo\Sesion;
use App\Nucleo\Vista;
use App\Repositorios\RepositorioClientes;
use App\Repositorios\RepositorioCuentas;
use App\Repositorios\RepositorioRetiros;
use App\Repositorios\RepositorioTransferencias;
use App\Servicios\ServicioTransacciones;

class ControladorBanco
{

    private function exigirSesion(): int
    {
        $cuentaId = Sesion::cuentaId();

        if ($cuentaId === null) {
            Router::redirigir('login');
        }

        return $cuentaId;
    }

    private function exigirCsrf(string $rutaSiFalla): void
    {
        if (!Csrf::validar($_POST['csrf'] ?? null)) {
            Sesion::flash('error', 'El formulario expiró. Inténtalo de nuevo.');
            Router::redirigir($rutaSiFalla);
        }
    }

    private function campo(string $nombre): string
    {
        $valor = $_POST[$nombre] ?? '';

        return is_string($valor) ? $valor : '';
    }

    public function mostrarPanel(): void
    {
        $cuentaId = $this->exigirSesion();

        $cuenta = RepositorioCuentas::buscarPorId($cuentaId);
        if ($cuenta === null) {
            Sesion::cerrar();
            Router::redirigir('login');
        }

        $cliente = RepositorioClientes::buscarPorId($cuenta->cliente_id);

        Vista::render('panel', [
            'nombreCliente' => $cliente?->nombre ?? 'Cliente',
            'numeroCuenta'  => $cuenta->numero_cuenta,
            'saldoActual'   => $cuenta->saldo,
        ]);
    }

    public function mostrarRetiro(): void
    {
        $this->exigirSesion();
        Vista::render('retiro');
    }

    public function procesarRetiro(): void
    {
        $cuentaId = $this->exigirSesion();
        $this->exigirCsrf('retiro');

        $resultado = ServicioTransacciones::retirar($cuentaId, $this->campo('valor'), $this->campo('clave'));

        Sesion::flash($resultado['exito'] ? 'exito' : 'error', $resultado['mensaje']);
        Router::redirigir($resultado['exito'] ? 'panel' : 'retiro');
    }

    public function mostrarTransferencia(): void
    {
        $this->exigirSesion();
        Vista::render('transferencia');
    }

    public function procesarTransferencia(): void
    {
        $cuentaId = $this->exigirSesion();
        $this->exigirCsrf('transferencia');

        $resultado = ServicioTransacciones::transferir(
            $cuentaId,
            $this->campo('cuenta_destino'),
            $this->campo('valor'),
            $this->campo('clave')
        );

        Sesion::flash($resultado['exito'] ? 'exito' : 'error', $resultado['mensaje']);
        Router::redirigir($resultado['exito'] ? 'panel' : 'transferencia');
    }

    public function mostrarHistorialRetiros(): void
    {
        $cuentaId = $this->exigirSesion();

        Vista::render('historial_retiros', [
            'retiros' => RepositorioRetiros::obtenerPorCuentaId($cuentaId),
        ]);
    }

    public function mostrarHistorialTransferencias(): void
    {
        $cuentaId = $this->exigirSesion();

        Vista::render('historial_transferencias', [
            'transferencias' => RepositorioTransferencias::obtenerEnviadasPorCuentaId($cuentaId),
        ]);
    }
}
