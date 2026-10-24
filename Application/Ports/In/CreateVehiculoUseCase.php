<?php

interface CreateVehiculoUseCase
{
    public function execute(CreateVehiculoCommand $command): void;
}
