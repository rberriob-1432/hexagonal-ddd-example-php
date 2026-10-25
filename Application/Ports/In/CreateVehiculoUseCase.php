<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/CreateVehiculoCommand.php';
require_once __DIR__ . '/../../../Domain/Models/VehiculoModel.php';

interface CreateVehiculoUseCase
{
    public function execute(CreateVehiculoCommand $command): VehiculoModel;
}
