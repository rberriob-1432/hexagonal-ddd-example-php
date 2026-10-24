
<?php

class VehiculoExcepcionPlaca extends InvalidArgumentException
{
    public static function porqueValorEstaVacio(): self
    {
        return new self('La placa del vehículo no puede estar vacía.');
    }

    public static function porqueFormatoEsInvalido(): self
    {
        return new self('El formato de la placa del vehículo no es válido.');
    }
}
