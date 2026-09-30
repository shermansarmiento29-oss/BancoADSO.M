<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Modelos\Usuario;
use PDO;

class RepositorioUsuarios
{

    public static function buscarPorNumeroCuenta(string $numeroCuenta): ?Usuario
    {
        $sql = 'SELECT u.id, u.cuenta_id, u.clave_hash
                FROM usuarios u
                JOIN cuentas c ON u.cuenta_id = c.id
                WHERE c.numero_cuenta = :numero_cuenta
                LIMIT 1';
        $stmt = Conexion::obtener()->prepare($sql);
        $stmt->execute(['numero_cuenta' => $numeroCuenta]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fila ? Usuario::desdeFila($fila) : null;
    }

    public static function buscarPorCuentaId(int $cuentaId): ?Usuario
    {
        $sql = 'SELECT id, cuenta_id, clave_hash FROM usuarios WHERE cuenta_id = :cuenta_id LIMIT 1';
        $stmt = Conexion::obtener()->prepare($sql);
        $stmt->execute(['cuenta_id' => $cuentaId]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fila ? Usuario::desdeFila($fila) : null;
    }
}
