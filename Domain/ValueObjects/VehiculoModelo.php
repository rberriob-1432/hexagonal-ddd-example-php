
<?php

require_once __DIR__ . '/../Exceptions/VehiculoExcepcionModelo.php';

class VehiculoModelo
{
    private string $value;

    public function __construct($value)
    {
        $normalizedValue = trim((string) $value);

        if ($normalizedValue === '') {
            throw VehiculoExcepcionModelo::porqueValorEsInvalido();
        }

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(VehiculoModelo $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
