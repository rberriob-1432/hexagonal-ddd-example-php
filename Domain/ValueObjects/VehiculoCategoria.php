
<?php

require_once __DIR__ . '/../Exceptions/VehiculoExcepcionCategoria.php';
require_once __DIR__ . '/../Enums/VehiculoCategoriaEnum.php';

class VehiculoCategoria
{
    private string $value;

    public function __construct($value)
    {
        $normalizedValue = strtoupper(trim((string) $value));

        if ($normalizedValue === '') {
            throw VehiculoExcepcionCategoria::porqueValorEstaVacio();
        }

        VehiculoCategoriaEnum::ensureIsValid($normalizedValue);

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(VehiculoCategoria $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
