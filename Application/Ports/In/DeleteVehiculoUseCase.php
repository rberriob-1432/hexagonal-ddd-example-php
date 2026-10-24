<?php

interface DeleteVehiculoUseCase
{
    public function execute(DeleteVehiculoCommand $command): void;
}
