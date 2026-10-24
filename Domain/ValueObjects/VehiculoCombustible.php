
<?php

require_once __DIR__ . '/../Exceptions/VehiculoExcepcionCombustible.php';
require_once __DIR__ . '/../Enums/VehiculoCombustibleEnum.php';

class VehiculoCombustible
{
    private string $value;

    public function __construct($value)
    {
        $normalizedValue = strtoupper(trim((string) $value));

        if ($normalizedValue === '') {
            throw VehiculoExcepcionCombustible::porqueValorEstaVacio();
        }

        VehiculoCombustibleEnum::ensureIsValid($normalizedValue);

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(VehiculoCombustible $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
