
<?php

require_once __DIR__ . '/../Exceptions/VehiculoExcepcionMarca.php';

class VehiculoMarca
{
    private string $value;

    public function __construct($value)
    {
        $normalizedValue = trim((string) $value);

        if ($normalizedValue === '') {
            throw VehiculoExcepcionMarca::porqueValorEstaVacio();
        }

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(VehiculoMarca $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
