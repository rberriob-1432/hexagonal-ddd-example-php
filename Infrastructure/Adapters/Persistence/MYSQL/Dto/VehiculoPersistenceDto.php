<?php

declare(strict_types=1);

final class VehiculoPersistenceDto
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

    public function placa(): string
    {
        return $this->placa;
    }

    public function marca(): string
    {
        return $this->marca;
    }

    public function modelo(): string
    {
        return $this->modelo;
    }

    public function version(): string
    {
        return $this->version;
    }

    public function color(): string
    {
        return $this->color;
    }

    public function numPuestos(): int
    {
        return $this->numPuestos;
    }

    public function numPuertas(): int
    {
        return $this->numPuertas;
    }

    public function combustible(): string
    {
        return $this->combustible;
    }

    public function kilometros(): int
    {
        return $this->kilometros;
    }

    public function cilindraje(): int
    {
        return $this->cilindraje;
    }

    public function categoria(): string
    {
        return $this->categoria;
    }
}