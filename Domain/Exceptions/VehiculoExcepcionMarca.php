
<?php

class VehiculoExcepcionMarca extends InvalidArgumentException
{
    public static function porqueValorEstaVacio(): self
    {
        return new self('La marca del vehículo no puede estar vacía.');
    }
}
