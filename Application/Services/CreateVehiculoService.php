<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/CreateVehiculoUseCase.php';
require_once __DIR__ . '/../Ports/Out/SaveVehiculoPort.php';
require_once __DIR__ . '/../Ports/Out/GetVehiculoByPlacaPort.php';
require_once __DIR__ . '/Mappers/VehiculoApplicationMapper.php';
require_once __DIR__ . '/../Services/Dto/Commands/CreateVehiculoCommand.php';
require_once __DIR__ . '/../../Domain/Models/VehiculoModel.php';

final class CreateVehiculoService implements CreateVehiculoUseCase
{
    private SaveVehiculoPort $saveVehiculoPort;
    private GetVehiculoByPlacaPort $getVehiculoByPlacaPort;

    public function __construct(
        SaveVehiculoPort $saveVehiculoPort,
        GetVehiculoByPlacaPort $getVehiculoByPlacaPort
    ) {
        $this->saveVehiculoPort = $saveVehiculoPort;
        $this->getVehiculoByPlacaPort = $getVehiculoByPlacaPort;
    }

    public function execute(CreateVehiculoCommand $command): VehiculoModel
    {
        $vehiculo = VehiculoApplicationMapper::fromCreateCommandToModel(
            $command
        );

        $existingVehiculo = $this->getVehiculoByPlacaPort->findByPlaca(
            $vehiculo->placa()
        );

        if ($existingVehiculo !== null) {
            throw new RuntimeException(
                'Ya existe un vehículo con la placa '
                . $vehiculo->placa()->value()
            );
        }

        $this->saveVehiculoPort->save($vehiculo);

        return $vehiculo;
    }
}