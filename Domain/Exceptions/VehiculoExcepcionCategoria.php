
<?php

class VehiculoExcepcionCategoria extends InvalidArgumentException
{
    public static function porqueValorEstaVacio(): self
    {
        return new self(
            'La categoría del vehículo no puede estar vacía.'
        );
    }

    public static function porqueValorEsInvalido($value): self
    {
        return new self(
            'La categoría del vehículo no es válida: ' . (string) $value
        );
    }
}
