<?php
namespace App\Modelos;

final class Retiro
{
    public function __construct(
        public readonly int $id,
        public readonly int $cuenta_id,
        public readonly float $valor,
        public readonly string $fecha
    ) {
    }

    public static function desdeFila(array $fila): self
    {
        return new self(
            id: (int) $fila['id'],
            cuenta_id: (int) $fila['cuenta_id'],
            valor: (float) $fila['valor'],
            fecha: $fila['fecha']
        );
    }
}
