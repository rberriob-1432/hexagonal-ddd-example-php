
<?php

require_once __DIR__ . '/EventDomain.php';
require_once __DIR__ . '/../Models/VehiculoModel.php';

class VehiculoDeletedDomainEvent extends DomainEvent
{
    private VehiculoModel $vehiculo;

    public function __construct(VehiculoModel $vehiculo)
    {
        parent::__construct('vehiculo.deleted');

        $this->vehiculo = $vehiculo;
    }

    public function vehiculo(): VehiculoModel
    {
        return $this->vehiculo;
    }

    public function payload(): array
    {
        return [
            'placa' => $this->vehiculo->placa()->value()
        ];
    }
}
