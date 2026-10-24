
<?php

class VehiculoExcepcionNumPuestos extends InvalidArgumentException
{
    public static function porqueCantidadEsInvalida(): self
    {
        return new self('El número de puestos debe ser mayor que cero.');
    }
}
