<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/UpdateVehiculoUseCase.php';
require_once __DIR__ . '/../Ports/Out/UpdateVehiculoPort.php';
require_once __DIR__ . '/../Ports/Out/GetVehiculoByPlacaPort.php';
require_once __DIR__ . '/Mappers/VehiculoApplicationMapper.php';
require_once __DIR__ . '/Dto/Commands/UpdateVehiculoCommand.php';
require_once __DIR__ . '/../../Domain/Models/VehiculoModel.php';

final class UpdateVehiculoService implements UpdateVehiculoUseCase
{
    private UpdateVehiculoPort $updateVehiculoPort;
    private GetVehiculoByPlacaPort $getVehiculoByPlacaPort;

    public function __construct(
        UpdateVehiculoPort $updateVehiculoPort,
        GetVehiculoByPlacaPort $getVehiculoByPlacaPort
    ) {
        $this->updateVehiculoPort = $updateVehiculoPort;
        $this->getVehiculoByPlacaPort = $getVehiculoByPlacaPort;
    }

    public function execute(UpdateVehiculoCommand $command): void
    {
        $placa = VehiculoApplicationMapper::
            fromDeleteCommandToVehiculoPlaca(
                new DeleteVehiculoCommand($command->getPlaca())
            );

        $existingVehiculo = $this->getVehiculoByPlacaPort->findByPlaca(
            $placa
        );

        if ($existingVehiculo === null) {
            throw new RuntimeException(
                'No existe un vehículo con la placa ' . $placa->value()
            );
        }

        $vehiculo = VehiculoApplicationMapper::fromUpdateCommandToModel(
            $command
        );

        $this->updateVehiculoPort->update($vehiculo);
    }
}