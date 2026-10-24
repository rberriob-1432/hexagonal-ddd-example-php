
<?php

require_once __DIR__ . '/../Exceptions/VehiculoExcepcionNumPuestos.php';

class VehiculoNumPuestos
{
    private int $value;

    public function __construct($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false
            || (int) $value <= 0) {
            throw VehiculoExcepcionNumPuestos::porqueCantidadEsInvalida();
        }

        $this->value = (int) $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(VehiculoNumPuestos $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
