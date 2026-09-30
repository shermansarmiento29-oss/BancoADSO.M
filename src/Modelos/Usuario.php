<?php
namespace App\Modelos;

final class Usuario
{
    public function __construct(
        public readonly int $id,
        public readonly int $cuenta_id,
        public readonly string $clave_hash
    ) {
    }

    public static function desdeFila(array $fila): self
    {
        return new self(
            id: (int) $fila['id'],
            cuenta_id: (int) $fila['cuenta_id'],
            clave_hash: $fila['clave_hash']
        );
    }
}
