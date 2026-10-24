<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/Commands/CreateVehiculoCommand.php';
require_once __DIR__ . '/../Dto/Commands/UpdateVehiculoCommand.php';
require_once __DIR__ . '/../Dto/Commands/DeleteVehiculoCommand.php';
require_once __DIR__ . '/../Dto/Queries/GetVehiculoByPlacaQuery.php';

require_once __DIR__ . '/../../../Domain/Models/VehiculoModel.php';

require_once __DIR__ . '/../../../Domain/ValueObjects/VehiculoPlaca.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/VehiculoMarca.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/VehiculoModelo.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/VehiculoVersion.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/VehiculoColor.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/VehiculoNumPuestos.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/VehiculoNumPuertas.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/VehiculoCombustible.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/VehiculoKilometros.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/VehiculoCilindraje.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/VehiculoCategoria.php';

final class VehiculoApplicationMapper
{
    public static function fromCreateCommandToModel(
        CreateVehiculoCommand $command
    ): VehiculoModel {
        return VehiculoModel::create(
            new VehiculoPlaca($command->getPlaca()),
            new VehiculoMarca($command->getMarca()),
            new VehiculoModelo($command->getModelo()),
            new VehiculoVersion($command->getVersion()),
            new VehiculoColor($command->getColor()),
            new VehiculoNumPuestos($command->getNumPuestos()),
            new VehiculoNumPuertas($command->getNumPuertas()),
            new VehiculoCombustible($command->getCombustible()),
            new VehiculoKilometros($command->getKilometros()),
            new VehiculoCilindraje($command->getCilindraje()),
            new VehiculoCategoria($command->getCategoria())
        );
    }

    public static function fromUpdateCommandToModel(
        UpdateVehiculoCommand $command
    ): VehiculoModel {
        return VehiculoModel::create(
            new VehiculoPlaca($command->getPlaca()),
            new VehiculoMarca($command->getMarca()),
            new VehiculoModelo($command->getModelo()),
            new VehiculoVersion($command->getVersion()),
            new VehiculoColor($command->getColor()),
            new VehiculoNumPuestos($command->getNumPuestos()),
            new VehiculoNumPuertas($command->getNumPuertas()),
            new VehiculoCombustible($command->getCombustible()),
            new VehiculoKilometros($command->getKilometros()),
            new VehiculoCilindraje($command->getCilindraje()),
            new VehiculoCategoria($command->getCategoria())
        );
    }

    public static function fromGetVehiculoByPlacaQueryToVehiculoPlaca(
        GetVehiculoByPlacaQuery $query
    ): VehiculoPlaca {
        return new VehiculoPlaca($query->getPlaca());
    }

    public static function fromDeleteCommandToVehiculoPlaca(
        DeleteVehiculoCommand $command
    ): VehiculoPlaca {
        return new VehiculoPlaca($command->getPlaca());
    }

    /**
     * @return array<string, string|int>
     */
    public static function fromModelToArray(
        VehiculoModel $vehiculo
    ): array {
        return $vehiculo->toArray();
    }

    /**
     * @param VehiculoModel[] $vehiculos
     * @return array<int, array<string, string|int>>
     */
    public static function fromModelsToArray(array $vehiculos): array
    {
        $result = [];

        foreach ($vehiculos as $vehiculo) {
            $result[] = self::fromModelToArray($vehiculo);
        }

        return $result;
    }
}
