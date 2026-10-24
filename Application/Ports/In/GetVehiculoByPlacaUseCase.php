<?php

interface GetVehiculoByPlacaUseCase
{
    public function execute(GetVehiculoByPlacaQuery $query): ?VehiculoModel;
}
