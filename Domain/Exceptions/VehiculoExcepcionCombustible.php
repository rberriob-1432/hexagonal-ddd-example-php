
<?php
class VehiculoExcepcionCombustible extends InvalidArgumentException
{
    public static function porqueValorEstaVacio(): self
    {
        return new self(
            'El tipo de combustible no puede estar vacío.'
        );
    }

    public static function porqueValorEsInvalido($value): self
    {
        return new self(
            'El tipo de combustible no es válido: ' . (string) $value
        );
    }
}
