<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetAllVehiculosUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetAllVehiculosPort.php';
require_once __DIR__ . '/Dto/Queries/GetAllVehiculosQuery.php';
require_once __DIR__ . '/../../Domain/Models/VehiculoModel.php';

final class GetAllVehiculosService implements GetAllVehiculosUseCase
{
    private GetAllVehiculosPort $getAllVehiculosPort;

    public function __construct(
        GetAllVehiculosPort $getAllVehiculosPort
    ) {
        $this->getAllVehiculosPort = $getAllVehiculosPort;
    }

    public function execute(GetAllVehiculosQuery $query): array
    {
        return $this->getAllVehiculosPort->findAll();
    }
}
