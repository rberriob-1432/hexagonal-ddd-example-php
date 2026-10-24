
<?php

class VehiculoExcepcionKilometros extends InvalidArgumentException
{
    public static function porqueValorEsNegativo(): self
    {
        return new self('Los kilómetros del vehículo no pueden ser negativos.');
    }
}
