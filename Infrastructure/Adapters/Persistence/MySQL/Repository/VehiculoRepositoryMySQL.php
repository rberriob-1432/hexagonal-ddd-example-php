<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../../../Application/Ports/Out/SaveVehiculoPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/UpdateVehiculoPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetVehiculoByPlacaPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetAllVehiculosPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/DeleteVehiculoPort.php';

require_once __DIR__ . '/../Mapper/VehiculoPersistenceMapper.php';
require_once __DIR__ . '/../Dto/VehiculoPersistenceDto.php';
require_once __DIR__ . '/../Entity/VehiculoEntity.php';

require_once __DIR__ . '/../../../../../Domain/Models/VehiculoModel.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/VehiculoPlaca.php';

final class VehiculoRepositoryMySQL implements
    SaveVehiculoPort,
    UpdateVehiculoPort,
    GetVehiculoByPlacaPort,
    GetAllVehiculosPort,
    DeleteVehiculoPort
{
    private PDO $pdo;
    private VehiculoPersistenceMapper $mapper;

    public function __construct(
        PDO $pdo,
        VehiculoPersistenceMapper $mapper
    ) {
        $this->pdo = $pdo;
        $this->mapper = $mapper;
    }

    public function save(VehiculoModel $vehiculo): void
    {
        $dto = $this->mapper->fromModelToDto($vehiculo);

        $sql = '
            INSERT INTO vehiculos (
                placa,
                marca,
                modelo,
                version,
                color,
                num_puestos,
                num_puertas,
                combustible,
                kilometros,
                cilindraje,
                categoria,
                created_at,
                updated_at
            ) VALUES (
                :placa,
                :marca,
                :modelo,
                :version,
                :color,
                :num_puestos,
                :num_puertas,
                :combustible,
                :kilometros,
                :cilindraje,
                :categoria,
                NOW(),
                NOW()
            )
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':placa' => $dto->placa(),
            ':marca' => $dto->marca(),
            ':modelo' => $dto->modelo(),
            ':version' => $dto->version(),
            ':color' => $dto->color(),
            ':num_puestos' => $dto->numPuestos(),
            ':num_puertas' => $dto->numPuertas(),
            ':combustible' => $dto->combustible(),
            ':kilometros' => $dto->kilometros(),
            ':cilindraje' => $dto->cilindraje(),
            ':categoria' => $dto->categoria(),
        ]);
    }

    public function update(VehiculoModel $vehiculo): void
    {
        $dto = $this->mapper->fromModelToDto($vehiculo);

        $sql = '
            UPDATE vehiculos
               SET marca = :marca,
                   modelo = :modelo,
                   version = :version,
                   color = :color,
                   num_puestos = :num_puestos,
                   num_puertas = :num_puertas,
                   combustible = :combustible,
                   kilometros = :kilometros,
                   cilindraje = :cilindraje,
                   categoria = :categoria,
                   updated_at = NOW()
             WHERE placa = :placa
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':placa' => $dto->placa(),
            ':marca' => $dto->marca(),
            ':modelo' => $dto->modelo(),
            ':version' => $dto->version(),
            ':color' => $dto->color(),
            ':num_puestos' => $dto->numPuestos(),
            ':num_puertas' => $dto->numPuertas(),
            ':combustible' => $dto->combustible(),
            ':kilometros' => $dto->kilometros(),
            ':cilindraje' => $dto->cilindraje(),
            ':categoria' => $dto->categoria(),
        ]);
    }

    public function findByPlaca(
        VehiculoPlaca $placa
    ): ?VehiculoModel {
        $sql = '
            SELECT
                placa,
                marca,
                modelo,
                version,
                color,
                num_puestos,
                num_puertas,
                combustible,
                kilometros,
                cilindraje,
                categoria,
                created_at,
                updated_at
            FROM vehiculos
            WHERE placa = :placa
            LIMIT 1
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':placa' => $placa->value(),
        ]);

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return $this->mapper->fromRowToModel($row);
    }

    /**
     * @return VehiculoModel[]
     */
    public function findAll(): array
    {
        $sql = '
            SELECT
                placa,
                marca,
                modelo,
                version,
                color,
                num_puestos,
                num_puertas,
                combustible,
                kilometros,
                cilindraje,
                categoria,
                created_at,
                updated_at
            FROM vehiculos
            ORDER BY marca ASC, modelo ASC
        ';

        $statement = $this->pdo->query($sql);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->mapper->fromRowsToModels($rows);
    }

    public function delete(VehiculoPlaca $placa): void
    {
        $sql = 'DELETE FROM vehiculos WHERE placa = :placa';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':placa' => $placa->value(),
        ]);
    }
}