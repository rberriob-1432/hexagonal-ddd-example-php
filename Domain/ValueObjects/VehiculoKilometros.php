
<?php

require_once __DIR__ . '/../Exceptions/VehiculoExcepcionKilometros.php';

class VehiculoKilometros
{
    private int $value;

    public function __construct($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false
            || (int) $value < 0) {
            throw VehiculoExcepcionKilometros::porqueValorEsNegativo();
        }

        $this->value = (int) $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(VehiculoKilometros $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
