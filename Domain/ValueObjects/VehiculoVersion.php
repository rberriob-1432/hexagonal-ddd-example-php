
<?php
require_once __DIR__ . '/../Exceptions/VehiculoExcepcionVersion.php';

class VehiculoVersion
{
    private string $value;

    public function __construct($value)
    {
        $normalizedValue = trim((string) $value);

        if ($normalizedValue === '') {
            throw VehiculoExcepcionVersion::porqueValorEstaVacio();
        }

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(VehiculoVersion $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}