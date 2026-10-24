<?php

interface GetVehiculoByPlacaPort
{
    public function findByPlaca(VehiculoPlaca $placa): ?VehiculoModel;
}
