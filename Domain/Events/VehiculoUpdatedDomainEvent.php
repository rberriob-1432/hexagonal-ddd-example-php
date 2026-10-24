
<?php

require_once __DIR__ . '/EventDomain.php';
require_once __DIR__ . '/../Models/VehiculoModel.php';

class VehiculoUpdatedDomainEvent extends DomainEvent
{
    private VehiculoModel $vehiculo;

    public function __construct(VehiculoModel $vehiculo)
    {
        parent::__construct('vehiculo.updated');

        $this->vehiculo = $vehiculo;
    }

    public function vehiculo(): VehiculoModel
    {
        return $this->vehiculo;
    }

    public function payload(): array
    {
        return $this->vehiculo->toArray();
    }
}
