<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Modelos\Cuentas;
use PDO;

class RepositorioCuentas
{
    public static function buscarPorId(int $id): ?Cuentas
    {
        $sql = 'SELECT id, numero_cuenta, saldo, cliente_id FROM cuentas WHERE id = :id LIMIT 1';
        $stmt = Conexion::obtener()->prepare($sql);
        $stmt->execute(['id' => $id]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fila ? Cuentas::desdeFila($fila) : null;
    }

    public static function buscarPorNumero(string $numeroCuenta): ?Cuentas
    {
        $sql = 'SELECT id, numero_cuenta, saldo, cliente_id FROM cuentas WHERE numero_cuenta = :numero_cuenta LIMIT 1';
        $stmt = Conexion::obtener()->prepare($sql);
        $stmt->execute(['numero_cuenta' => $numeroCuenta]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fila ? Cuentas::desdeFila($fila) : null;
    }

    public static function bloquear(array $ids): void
    {
        $ids = array_values(array_unique(array_map('intval', $ids)));
        sort($ids);

        $marcadores = implode(',', array_fill(0, count($ids), '?'));
        $stmt = Conexion::obtener()->prepare("SELECT id FROM cuentas WHERE id IN ($marcadores) ORDER BY id FOR UPDATE");
        $stmt->execute($ids);
    }

    public static function debitar(int $id, string $valor): bool
    {
        $sql = 'UPDATE cuentas
                SET saldo = saldo - CAST(:valor AS DECIMAL(12,2))
                WHERE id = :id AND saldo >= CAST(:minimo AS DECIMAL(12,2))';
        $stmt = Conexion::obtener()->prepare($sql);
        $stmt->execute(['valor' => $valor, 'id' => $id, 'minimo' => $valor]);

        return $stmt->rowCount() === 1;
    }

    public static function acreditar(int $id, string $valor): bool
    {
        $sql = 'UPDATE cuentas SET saldo = saldo + CAST(:valor AS DECIMAL(12,2)) WHERE id = :id';
        $stmt = Conexion::obtener()->prepare($sql);
        $stmt->execute(['valor' => $valor, 'id' => $id]);

        return $stmt->rowCount() === 1;
    }
}
