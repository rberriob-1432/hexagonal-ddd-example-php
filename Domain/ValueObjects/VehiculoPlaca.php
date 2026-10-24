
<?php

require_once __DIR__ . '/../Exceptions/VehiculoExcepcionPlaca.php';

class VehiculoPlaca
{
    private string $value;

    public function __construct($value)
    {
        $normalizedValue = strtoupper(trim((string) $value));

        if ($normalizedValue === '') {
            throw VehiculoExcepcionPlaca::porqueValorEstaVacio();
        }

        if (!preg_match('/^[A-Z0-9-]+$/', $normalizedValue)) {
            throw VehiculoExcepcionPlaca::porqueFormatoEsInvalido();
        }

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(VehiculoPlaca $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
