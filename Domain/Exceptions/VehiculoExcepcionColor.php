
<?php

class VehiculoExcepcionColor extends InvalidArgumentException
{
    public static function porqueValorEstaVacio(): self
    {
        return new self('El color del vehículo no puede estar vacío.');
    }
}
