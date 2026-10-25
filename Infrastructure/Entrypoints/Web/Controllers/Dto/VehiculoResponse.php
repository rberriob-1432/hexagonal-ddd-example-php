<?php
declare(strict_types=1);

final class VehiculoResponse
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
        $this->placa = $placa;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->version = $version;
        $this->color = $color;
        $this->numPuestos = $numPuestos;
        $this->numPuertas = $numPuertas;
        $this->combustible = $combustible;
        $this->kilometros = $kilometros;
        $this->cilindraje = $cilindraje;
        $this->categoria = $categoria;
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

    /**
     * @return array<string, string|int>
     */
    public function toArray(): array
    {
        return array(
            'placa' => $this->placa,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'version' => $this->version,
            'color' => $this->color,
            'num_puestos' => $this->numPuestos,
            'num_puertas' => $this->numPuertas,
            'combustible' => $this->combustible,
            'kilometros' => $this->kilometros,
            'cilindraje' => $this->cilindraje,
            'categoria' => $this->categoria,
        );
    }
}
