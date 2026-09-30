<?php
namespace App\Modelos;

final class Clientes
{
    public function __construct(
        public readonly int $id,
        public readonly string $nombre
    ) {}

    public static function desdeFila(array $fila): self
    {
        return new self(
            id: (int) $fila['id'],
            nombre: (string) $fila['nombre']
        );
    }
}