<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/DeleteVehiculoUseCase.php';
require_once __DIR__ . '/../Ports/Out/DeleteVehiculoPort.php';
require_once __DIR__ . '/../Ports/Out/GetVehiculoByPlacaPort.php';
require_once __DIR__ . '/Mappers/VehiculoApplicationMapper.php';
require_once __DIR__ . '/Dto/Commands/DeleteVehiculoCommand.php';

final class DeleteVehiculoService implements DeleteVehiculoUseCase
{
    private DeleteVehiculoPort $deleteVehiculoPort;
    private GetVehiculoByPlacaPort $getVehiculoByPlacaPort;

    public function __construct(
        DeleteVehiculoPort $deleteVehiculoPort,
        GetVehiculoByPlacaPort $getVehiculoByPlacaPort
    ) {
        $this->deleteVehiculoPort = $deleteVehiculoPort;
        $this->getVehiculoByPlacaPort = $getVehiculoByPlacaPort;
    }

    public function execute(DeleteVehiculoCommand $command): void
    {
        $placa = VehiculoApplicationMapper::
            fromDeleteCommandToVehiculoPlaca($command);

        $vehiculo = $this->getVehiculoByPlacaPort->findByPlaca($placa);

        if ($vehiculo === null) {
            throw new RuntimeException(
                'No existe un vehículo con la placa ' . $placa->value()
            );
        }

        $this->deleteVehiculoPort->delete($placa);
    }
}
