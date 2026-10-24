
<?php

require_once __DIR__ . '/../Exceptions/VehiculoExcepcionColor.php';

class VehiculoColor
{
    private string $value;

    public function __construct($value)
    {
        $normalizedValue = trim((string) $value);

        if ($normalizedValue === '') {
            throw VehiculoExcepcionColor::porqueValorEstaVacio();
        }

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(VehiculoColor $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
