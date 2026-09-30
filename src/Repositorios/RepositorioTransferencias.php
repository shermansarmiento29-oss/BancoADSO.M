<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Modelos\Transferencia;
use PDO;

class RepositorioTransferencias
{
    public static function registrar(int $cuentaOrigenId, int $cuentaDestinoId, string $valor): bool
    {
        $sql = 'INSERT INTO transferencias (cuenta_origen_id, cuenta_destino_id, valor, fecha)
                VALUES (:origen, :destino, :valor, NOW())';
        $stmt = Conexion::obtener()->prepare($sql);

        return $stmt->execute([
            'origen'  => $cuentaOrigenId,
            'destino' => $cuentaDestinoId,
            'valor'   => $valor,
        ]);
    }

    public static function obtenerEnviadasPorCuentaId(int $cuentaId): array
    {
        $sql = 'SELECT t.id, t.cuenta_origen_id, t.cuenta_destino_id, t.valor, t.fecha,
                       c.numero_cuenta AS numero_cuenta_destino
                FROM transferencias t
                JOIN cuentas c ON c.id = t.cuenta_destino_id
                WHERE t.cuenta_origen_id = :cuenta_id
                ORDER BY t.fecha DESC, t.id DESC';
        $stmt = Conexion::obtener()->prepare($sql);
        $stmt->execute(['cuenta_id' => $cuentaId]);

        return array_map([Transferencia::class, 'desdeFila'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
