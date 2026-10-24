<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetVehiculoByPlacaUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetVehiculoByPlacaPort.php';
require_once __DIR__ . '/Mappers/VehiculoApplicationMapper.php';
require_once __DIR__ . '/Dto/Queries/GetVehiculoByPlacaQuery.php';
require_once __DIR__ . '/../../Domain/Models/VehiculoModel.php';

final class GetVehiculoByPlacaService implements GetVehiculoByPlacaUseCase
{
    private GetVehiculoByPlacaPort $getVehiculoByPlacaPort;

    public function __construct(
        GetVehiculoByPlacaPort $getVehiculoByPlacaPort
    ) {
        $this->getVehiculoByPlacaPort = $getVehiculoByPlacaPort;
    }

    public function execute(
        GetVehiculoByPlacaQuery $query
    ): ?VehiculoModel {
        $placa = VehiculoApplicationMapper::
            fromGetVehiculoByPlacaQueryToVehiculoPlaca($query);

        return $this->getVehiculoByPlacaPort->findByPlaca($placa);
    }
}
