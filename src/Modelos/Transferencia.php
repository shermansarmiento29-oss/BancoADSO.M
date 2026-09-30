<?php
namespace App\Modelos;

final class Transferencia
{
    public function __construct(
        public readonly int $id,
        public readonly int $cuenta_origen_id,
        public readonly int $cuenta_destino_id,
        public readonly float $valor,
        public readonly string $fecha,

        public readonly ?string $numero_cuenta_destino = null
    ) {
    }

    public static function desdeFila(array $fila): self
    {
        return new self(
            id: (int) $fila['id'],
            cuenta_origen_id: (int) $fila['cuenta_origen_id'],
            cuenta_destino_id: (int) $fila['cuenta_destino_id'],
            valor: (float) $fila['valor'],
            fecha: (string) $fila['fecha'],
            numero_cuenta_destino: isset($fila['numero_cuenta_destino'])
                ? (string) $fila['numero_cuenta_destino']
                : null
        );
    }
}
