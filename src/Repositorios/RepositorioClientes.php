<?php

namespace App\Repositorios;

use App\Nucleo\Conexion;
use App\Modelos\Clientes;
use PDO;

class RepositorioClientes
{
    public static function buscarPorId(int $id): ?Clientes
    {
        $stmt = Conexion::obtener()->prepare('SELECT id, nombre FROM clientes WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fila ? Clientes::desdeFila($fila) : null;
    }
}
