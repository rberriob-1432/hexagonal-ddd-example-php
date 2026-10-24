<?php

interface UpdateVehiculoUseCase
{
    public function execute(UpdateVehiculoCommand $command): void;
}
