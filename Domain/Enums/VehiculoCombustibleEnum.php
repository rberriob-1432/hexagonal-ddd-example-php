
<?php

require_once __DIR__ . '/../Exceptions/VehiculoExcepcionCombustible.php';

class VehiculoCombustibleEnum
{
    public const GASOLINA = 'GASOLINA';
    public const DIESEL = 'DIESEL';
    public const ELECTRICO = 'ELECTRICO';
    public const HIBRIDO = 'HIBRIDO';
    public const GAS = 'GAS';

    public static function values(): array
    {
        return [
            self::GASOLINA,
            self::DIESEL,
            self::ELECTRICO,
            self::HIBRIDO,
            self::GAS
        ];
    }

    public static function isValid($value): bool
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid($value): void
    {
        if (!self::isValid($value)) {
            throw VehiculoExcepcionCombustible::porqueValorEsInvalido(
                $value
            );
        }
    }
}
