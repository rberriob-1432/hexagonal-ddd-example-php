
<?php

require_once __DIR__ . '/../Exceptions/VehiculoExcepcionCategoria.php';

class VehiculoCategoriaEnum
{
    public const AUTOMOVIL = 'AUTOMOVIL';
    public const MOTOCICLETA = 'MOTOCICLETA';
    public const CAMIONETA = 'CAMIONETA';
    public const CAMION = 'CAMION';
    public const BUS = 'BUS';
    public const CAMIONETA_CARGA = 'CAMIONETA_CARGA';

    public static function values(): array
    {
        return [
            self::AUTOMOVIL,
            self::MOTOCICLETA,
            self::CAMIONETA,
            self::CAMION,
            self::BUS,
            self::CAMIONETA_CARGA
        ];
    }

    public static function isValid($value): bool
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid($value): void
    {
        if (!self::isValid($value)) {
            throw VehiculoExcepcionCategoria::porqueValorEsInvalido(
                $value
            );
        }
    }
}
