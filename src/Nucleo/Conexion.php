<?php

namespace App\Nucleo;

use PDO;
use PDOException;

class Conexion
{
    private static ?PDO $instancia = null;

    private function __construct() {}

    public static function obtener(): PDO
    {
        if (self::$instancia === null) {
            $config = require __DIR__ . '/../../config/basedatos.php';

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['basedatos'],
                $config['charset']
            );

            $opciones = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instancia = new PDO($dsn, $config['usuario'], $config['clave'], $opciones);
            } catch (PDOException $e) {

                error_log('Error de conexión a la base de datos: ' . $e->getMessage());
                http_response_code(500);
                exit('No se pudo conectar a la base de datos. Intenta más tarde.');
            }
        }

        return self::$instancia;
    }
}
