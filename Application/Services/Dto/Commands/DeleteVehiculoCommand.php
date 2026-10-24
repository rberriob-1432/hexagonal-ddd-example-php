<?php

declare(strict_types=1);

final class DeleteVehiculoCommand
{
    private string $placa;

    public function __construct(string $placa)
    {
        $this->placa = strtoupper(trim($placa));
    }

    public function getPlaca(): string
    {
        return $this->placa;
    }
}
