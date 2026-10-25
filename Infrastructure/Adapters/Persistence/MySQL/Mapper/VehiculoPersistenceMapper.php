<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/VehiculoPersistenceDto.php';
require_once __DIR__ . '/../Entity/VehiculoEntity.php';

require_once __DIR__ . '/../../../../../Domain/Models/VehiculoModel.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoPlaca.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoMarca.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoModelo.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoVersion.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoColor.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoNumPuestos.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoNumPuertas.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoCombustible.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoKilometros.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoCilindraje.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoCategoria.php';

final class VehiculoPersistenceMapper
{
    public function fromModelToDto(
        VehiculoModel $vehiculo
    ): VehiculoPersistenceDto {
        return new VehiculoPersistenceDto(
            $vehiculo->placa()->value(),
            $vehiculo->marca()->value(),
            $vehiculo->modelo()->value(),
            $vehiculo->version()->value(),
            $vehiculo->color()->value(),
            $vehiculo->numPuestos()->value(),
            $vehiculo->numPuertas()->value(),
            $vehiculo->combustible()->value(),
            $vehiculo->kilometros()->value(),
            $vehiculo->cilindraje()->value(),
            $vehiculo->categoria()->value()
        );
    }

    public function fromDtoToEntity(
        VehiculoPersistenceDto $dto
    ): VehiculoEntity {
        return new VehiculoEntity(
            $dto->placa(),
            $dto->marca(),
            $dto->modelo(),
            $dto->version(),
            $dto->color(),
            $dto->numPuestos(),
            $dto->numPuertas(),
            $dto->combustible(),
            $dto->kilometros(),
            $dto->cilindraje(),
            $dto->categoria()
        );
    }

    public function fromRowToEntity(array $row): VehiculoEntity
    {
        return new VehiculoEntity(
            (string) $row['placa'],
            (string) $row['marca'],
            (string) $row['modelo'],
            (string) $row['version'],
            (string) $row['color'],
            (int) $row['num_puestos'],
            (int) $row['num_puertas'],
            (string) $row['combustible'],
            (int) $row['kilometros'],
            (int) $row['cilindraje'],
            (string) $row['categoria'],
            isset($row['created_at'])
                ? (string) $row['created_at']
                : null,
            isset($row['updated_at'])
                ? (string) $row['updated_at']
                : null
        );
    }

    public function fromEntityToModel(
        VehiculoEntity $entity
    ): VehiculoModel {
        return VehiculoModel::create(
            new VehiculoPlaca($entity->placa()),
            new VehiculoMarca($entity->marca()),
            new VehiculoModelo($entity->modelo()),
            new VehiculoVersion($entity->version()),
            new VehiculoColor($entity->color()),
            new VehiculoNumPuestos($entity->numPuestos()),
            new VehiculoNumPuertas($entity->numPuertas()),
            new VehiculoCombustible($entity->combustible()),
            new VehiculoKilometros($entity->kilometros()),
            new VehiculoCilindraje($entity->cilindraje()),
            new VehiculoCategoria($entity->categoria())
        );
    }

    public function fromRowToModel(array $row): VehiculoModel
    {
        return $this->fromEntityToModel(
            $this->fromRowToEntity($row)
        );
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @return VehiculoModel[]
     */
    public function fromRowsToModels(array $rows): array
    {
        $models = array();

        foreach ($rows as $row) {
            $models[] = $this->fromRowToModel($row);
        }

        return $models;
    }
}