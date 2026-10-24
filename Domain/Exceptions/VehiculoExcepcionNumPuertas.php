
<?php

class VehiculoExcepcionNumPuertas extends InvalidArgumentException
{
    public static function porqueCantidadEsInvalida(): self
    {
        return new self('El número de puertas debe ser mayor que cero.');
    }
}
