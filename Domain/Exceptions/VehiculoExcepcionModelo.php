
<?php

class VehiculoExcepcionModelo extends InvalidArgumentException
{
    public static function porqueValorEsInvalido(): self
    {
        return new self('El modelo del vehículo debe ser válido.');
    }
}
