<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetAllVehiculosQuery.php';
require_once __DIR__ . '/../../../Domain/Models/VehiculoModel.php';

interface GetAllVehiculosUseCase
{
    /**
     * @return VehiculoModel[]
     */
    public function execute(GetAllVehiculosQuery $query): array;
}
