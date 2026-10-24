<?php

declare(strict_types=1);

require_once __DIR__ . '/../ValueObjects/VehiculoPlaca.php';
require_once __DIR__ . '/../ValueObjects/VehiculoMarca.php';
require_once __DIR__ . '/../ValueObjects/VehiculoModelo.php';
require_once __DIR__ . '/../ValueObjects/VehiculoVersion.php';
require_once __DIR__ . '/../ValueObjects/VehiculoColor.php';
require_once __DIR__ . '/../ValueObjects/VehiculoNumPuestos.php';
require_once __DIR__ . '/../ValueObjects/VehiculoNumPuertas.php';
require_once __DIR__ . '/../ValueObjects/VehiculoCombustible.php';
require_once __DIR__ . '/../ValueObjects/VehiculoKilometros.php';
require_once __DIR__ . '/../ValueObjects/VehiculoCilindraje.php';
require_once __DIR__ . '/../ValueObjects/VehiculoCategoria.php';

final class VehiculoModel
{
    private VehiculoPlaca $placa;
    private VehiculoMarca $marca;
    private VehiculoModelo $modelo;
    private VehiculoVersion $version;
    private VehiculoColor $color;
    private VehiculoNumPuestos $numPuestos;
    private VehiculoNumPuertas $numPuertas;
    private VehiculoCombustible $combustible;
    private VehiculoKilometros $kilometros;
    private VehiculoCilindraje $cilindraje;
    private VehiculoCategoria $categoria;

    public function __construct(
        VehiculoPlaca $placa,
        VehiculoMarca $marca,
        VehiculoModelo $modelo,
        VehiculoVersion $version,
        VehiculoColor $color,
        VehiculoNumPuestos $numPuestos,
        VehiculoNumPuertas $numPuertas,
        VehiculoCombustible $combustible,
        VehiculoKilometros $kilometros,
        VehiculoCilindraje $cilindraje,
        VehiculoCategoria $categoria
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

    public static function create(
        VehiculoPlaca $placa,
        VehiculoMarca $marca,
        VehiculoModelo $modelo,
        VehiculoVersion $version,
        VehiculoColor $color,
        VehiculoNumPuestos $numPuestos,
        VehiculoNumPuertas $numPuertas,
        VehiculoCombustible $combustible,
        VehiculoKilometros $kilometros,
        VehiculoCilindraje $cilindraje,
        VehiculoCategoria $categoria
    ): self {
        return new self(
            $placa,
            $marca,
            $modelo,
            $version,
            $color,
            $numPuestos,
            $numPuertas,
            $combustible,
            $kilometros,
            $cilindraje,
            $categoria
        );
    }

    public function placa(): VehiculoPlaca
    {
        return $this->placa;
    }

    public function marca(): VehiculoMarca
    {
        return $this->marca;
    }

    public function modelo(): VehiculoModelo
    {
        return $this->modelo;
    }

    public function version(): VehiculoVersion
    {
        return $this->version;
    }

    public function color(): VehiculoColor
    {
        return $this->color;
    }

    public function numPuestos(): VehiculoNumPuestos
    {
        return $this->numPuestos;
    }

    public function numPuertas(): VehiculoNumPuertas
    {
        return $this->numPuertas;
    }

    public function combustible(): VehiculoCombustible
    {
        return $this->combustible;
    }

    public function kilometros(): VehiculoKilometros
    {
        return $this->kilometros;
    }

    public function cilindraje(): VehiculoCilindraje
    {
        return $this->cilindraje;
    }

    public function categoria(): VehiculoCategoria
    {
        return $this->categoria;
    }

    public function changeColor(VehiculoColor $color): self
    {
        return new self(
            $this->placa,
            $this->marca,
            $this->modelo,
            $this->version,
            $color,
            $this->numPuestos,
            $this->numPuertas,
            $this->combustible,
            $this->kilometros,
            $this->cilindraje,
            $this->categoria
        );
    }

    public function changeKilometros(
        VehiculoKilometros $kilometros
    ): self {
        return new self(
            $this->placa,
            $this->marca,
            $this->modelo,
            $this->version,
            $this->color,
            $this->numPuestos,
            $this->numPuertas,
            $this->combustible,
            $kilometros,
            $this->cilindraje,
            $this->categoria
        );
    }

    public function toArray(): array
    {
        return [
            'placa' => $this->placa->value(),
            'marca' => $this->marca->value(),
            'modelo' => $this->modelo->value(),
            'version' => $this->version->value(),
            'color' => $this->color->value(),
            'numPuestos' => $this->numPuestos->value(),
            'numPuertas' => $this->numPuertas->value(),
            'combustible' => $this->combustible->value(),
            'kilometros' => $this->kilometros->value(),
            'cilindraje' => $this->cilindraje->value(),
            'categoria' => $this->categoria->value()
        ];
    }
}
