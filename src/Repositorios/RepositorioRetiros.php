<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Modelos\Retiro;
use PDO;

class RepositorioRetiros
{

    public static function registrar(int $cuentaId, string $valor): bool
    {
        $sql = 'INSERT INTO retiros (cuenta_id, valor, fecha) VALUES (:cuenta_id, :valor, NOW())';
        $stmt = Conexion::obtener()->prepare($sql);

        return $stmt->execute(['cuenta_id' => $cuentaId, 'valor' => $valor]);
    }

    public static function obtenerPorCuentaId(int $cuentaId): array
    {
        $sql = 'SELECT id, cuenta_id, valor, fecha FROM retiros WHERE cuenta_id = :cuenta_id ORDER BY fecha DESC, id DESC';
        $stmt = Conexion::obtener()->prepare($sql);
        $stmt->execute(['cuenta_id' => $cuentaId]);

        return array_map([Retiro::class, 'desdeFila'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
