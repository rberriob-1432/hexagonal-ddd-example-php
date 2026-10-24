
<?php

class VehiculoExcepcionVersion extends InvalidArgumentException
{
    public static function porqueValorEstaVacio(): self
    {
        return new self('La versión del vehículo no puede estar vacía.');
    }
}
