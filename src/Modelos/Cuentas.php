<?php
namespace App\Modelos;

final class Cuentas
{
    public function __construct(
        public readonly int $id,
        public readonly string $numero_cuenta,
        public readonly float $saldo,
        public readonly int $cliente_id
    ) {}

    public static function desdeFila(array $fila): self
    {
        return new self(
            id: (int) $fila['id'],
            numero_cuenta: (string) $fila['numero_cuenta'],
            saldo: (float) $fila['saldo'],
            cliente_id: (int) $fila['cliente_id']
        );
    }
}