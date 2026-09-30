<?php

namespace App\Servicios;

use App\Nucleo\Conexion;
use App\Repositorios\RepositorioCuentas;
use App\Repositorios\RepositorioRetiros;
use App\Repositorios\RepositorioTransferencias;
use App\Repositorios\RepositorioUsuarios;
use Throwable;

class ServicioTransacciones
{

    private static function normalizarValor(string $entrada): ?string
    {
        $valor = str_replace(',', '.', trim($entrada));

        if (!preg_match('/^\d{1,10}(\.\d{1,2})?$/', $valor) || (float) $valor <= 0) {
            return null;
        }

        return $valor;
    }

    private static function claveCorrecta(int $cuentaId, string $clave): bool
    {
        $usuario = RepositorioUsuarios::buscarPorCuentaId($cuentaId);

        return $usuario !== null && password_verify($clave, $usuario->clave_hash);
    }

    public static function retirar(int $cuentaId, string $valorEntrada, string $clave): array
    {
        $valor = self::normalizarValor($valorEntrada);
        if ($valor === null) {
            return ['exito' => false, 'mensaje' => 'Ingresa un valor mayor a cero (máximo 2 decimales).'];
        }

        if (!self::claveCorrecta($cuentaId, $clave)) {
            return ['exito' => false, 'mensaje' => 'Contraseña incorrecta.'];
        }

        $pdo = Conexion::obtener();

        try {
            $pdo->beginTransaction();

            RepositorioCuentas::bloquear([$cuentaId]);

            if (!RepositorioCuentas::debitar($cuentaId, $valor)) {
                $pdo->rollBack();
                return ['exito' => false, 'mensaje' => 'Saldo insuficiente para realizar el retiro.'];
            }

            RepositorioRetiros::registrar($cuentaId, $valor);

            $pdo->commit();
            return ['exito' => true, 'mensaje' => 'Retiro realizado con éxito.'];
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Error en retiro: ' . $e->getMessage());
            return ['exito' => false, 'mensaje' => 'Error interno durante el retiro. No se descontó nada.'];
        }
    }

    public static function transferir(int $cuentaOrigenId, string $numeroCuentaDestino, string $valorEntrada, string $clave): array
    {
        $valor = self::normalizarValor($valorEntrada);
        if ($valor === null) {
            return ['exito' => false, 'mensaje' => 'Ingresa un valor mayor a cero (máximo 2 decimales).'];
        }

        if (!self::claveCorrecta($cuentaOrigenId, $clave)) {
            return ['exito' => false, 'mensaje' => 'Contraseña incorrecta.'];
        }

        $cuentaDestino = RepositorioCuentas::buscarPorNumero(trim($numeroCuentaDestino));
        if ($cuentaDestino === null) {
            return ['exito' => false, 'mensaje' => 'La cuenta destino ingresada no existe.'];
        }

        if ($cuentaDestino->id === $cuentaOrigenId) {
            return ['exito' => false, 'mensaje' => 'No puedes transferir a tu propia cuenta.'];
        }

        $pdo = Conexion::obtener();

        try {
            $pdo->beginTransaction();

            RepositorioCuentas::bloquear([$cuentaOrigenId, $cuentaDestino->id]);

            if (!RepositorioCuentas::debitar($cuentaOrigenId, $valor)) {
                $pdo->rollBack();
                return ['exito' => false, 'mensaje' => 'Saldo insuficiente para cubrir la transferencia.'];
            }

            RepositorioCuentas::acreditar($cuentaDestino->id, $valor);
            RepositorioTransferencias::registrar($cuentaOrigenId, $cuentaDestino->id, $valor);

            $pdo->commit();
            return ['exito' => true, 'mensaje' => 'Transferencia realizada con éxito.'];
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Error en transferencia: ' . $e->getMessage());
            return ['exito' => false, 'mensaje' => 'Error en la transacción. La operación fue revertida.'];
        }
    }
}
