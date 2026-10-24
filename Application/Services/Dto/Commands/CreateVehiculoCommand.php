<?php

declare(strict_types=1);

final class CreateVehiculoCommand
{
    private string $placa;
    private string $marca;
    private string $modelo;
    private string $version;
    private string $color;
    private int $numPuestos;
    private int $numPuertas;
    private string $combustible;
    private int $kilometros;
    private int $cilindraje;
    private string $categoria;

    public function __construct(
        string $placa,
        string $marca,
        string $modelo,
        string $version,
        string $color,
        int $numPuestos,
        int $numPuertas,
        string $combustible,
        int $kilometros,
        int $cilindraje,
        string $categoria
    ) {
        $this->placa = strtoupper(trim($placa));
        $this->marca = trim($marca);
        $this->modelo = trim($modelo);
        $this->version = trim($version);
        $this->color = trim($color);
        $this->numPuestos = $numPuestos;
        $this->numPuertas = $numPuertas;
        $this->combustible = strtoupper(trim($combustible));
        $this->kilometros = $kilometros;
        $this->cilindraje = $cilindraje;
        $this->categoria = strtoupper(trim($categoria));
    }

    public function getPlaca(): string
    {
        return $this->placa;
    }

    public function getMarca(): string
    {
        return $this->marca;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getNumPuestos(): int
    {
        return $this->numPuestos;
    }

    public function getNumPuertas(): int
    {
        return $this->numPuertas;
    }

    public function getCombustible(): string
    {
        return $this->combustible;
    }

    public function getKilometros(): int
    {
        return $this->kilometros;
    }

    public function getCilindraje(): int
    {
        return $this->cilindraje;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }
}
