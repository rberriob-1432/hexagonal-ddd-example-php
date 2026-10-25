<?php

declare(strict_types=1);

require_once __DIR__ . '/Mapper/VehiculoWebMapper.php';

require_once __DIR__ . '/../../../../Application/Ports/In/CreateVehiculoUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/UpdateVehiculoUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetVehiculoByPlacaUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetAllVehiculosUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/DeleteVehiculoUseCase.php';

require_once __DIR__ . '/../../../../Application/Services/Dto/Queries/GetAllVehiculosQuery.php';

require_once __DIR__ . '/Dto/CreateVehiculoWebRequest.php';
require_once __DIR__ . '/Dto/UpdateVehiculoWebRequest.php';
require_once __DIR__ . '/Dto/VehiculoResponse.php';

final class VehiculoController
{
    private CreateVehiculoUseCase $createVehiculoUseCase;
    private UpdateVehiculoUseCase $updateVehiculoUseCase;
    private GetVehiculoByPlacaUseCase $getVehiculoByPlacaUseCase;
    private GetAllVehiculosUseCase $getAllVehiculosUseCase;
    private DeleteVehiculoUseCase $deleteVehiculoUseCase;
    private VehiculoWebMapper $mapper;

    public function __construct(
        CreateVehiculoUseCase $createVehiculoUseCase,
        UpdateVehiculoUseCase $updateVehiculoUseCase,
        GetVehiculoByPlacaUseCase $getVehiculoByPlacaUseCase,
        GetAllVehiculosUseCase $getAllVehiculosUseCase,
        DeleteVehiculoUseCase $deleteVehiculoUseCase,
        VehiculoWebMapper $mapper
    ) {
        $this->createVehiculoUseCase = $createVehiculoUseCase;
        $this->updateVehiculoUseCase = $updateVehiculoUseCase;
        $this->getVehiculoByPlacaUseCase = $getVehiculoByPlacaUseCase;
        $this->getAllVehiculosUseCase = $getAllVehiculosUseCase;
        $this->deleteVehiculoUseCase = $deleteVehiculoUseCase;
        $this->mapper = $mapper;
    }

    /**
     * @return VehiculoResponse[]
     */
    public function index(): array
    {
        $vehiculos = $this->getAllVehiculosUseCase->execute(
            new GetAllVehiculosQuery()
        );

        return $this->mapper->fromModelsToResponses($vehiculos);
    }

    public function show(string $placa): VehiculoResponse
    {
        $query = $this->mapper->fromPlacaToGetByPlacaQuery($placa);

        $vehiculo = $this->getVehiculoByPlacaUseCase->execute($query);

        if ($vehiculo === null) {
            throw new RuntimeException(
                'No se encontró un vehículo con la placa indicada.'
            );
        }

        return $this->mapper->fromModelToResponse($vehiculo);
    }

    public function store(
        CreateVehiculoWebRequest $request
    ): VehiculoResponse {
        $command = $this->mapper->fromCreateRequestToCommand($request);

        $vehiculo = $this->createVehiculoUseCase->execute($command);

        return $this->mapper->fromModelToResponse($vehiculo);
    }

    public function update(UpdateVehiculoWebRequest $request): void
    {
        $command = $this->mapper->fromUpdateRequestToCommand($request);

        $this->updateVehiculoUseCase->execute($command);
    }

    public function delete(string $placa): void
    {
        $command = $this->mapper->fromPlacaToDeleteCommand($placa);

        $this->deleteVehiculoUseCase->execute($command);
    }
}
