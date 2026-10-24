
<?php

class VehiculoExcepcionCilindraje extends InvalidArgumentException
{
    public static function porqueValorEsInvalido(): self
    {
        return new self('El cilindraje del vehículo debe ser mayor que cero.');
    }
}
