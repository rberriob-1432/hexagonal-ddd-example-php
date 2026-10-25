<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/VehiculoModel.php';

interface GetAllVehiculosPort
{
    /**
     * @return VehiculoModel[]
     */
    public function findAll(): array;
}
