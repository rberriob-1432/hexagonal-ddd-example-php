<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/CreateVehiculoWebRequest.php';
require_once __DIR__ . '/../Dto/UpdateVehiculoWebRequest.php';
require_once __DIR__ . '/../Dto/VehiculoResponse.php';

require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/CreateVehiculoCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/UpdateVehiculoCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/DeleteVehiculoCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Queries/GetVehiculoByPlacaQuery.php';

require_once __DIR__ . '/../../../../../Domain/Models/VehiculoModel.php';

final class VehiculoWebMapper
{
    public function fromCreateRequestToCommand(
        CreateVehiculoWebRequest $request
    ): CreateVehiculoCommand {
        return new CreateVehiculoCommand(
            $request->getPlaca(),
            $request->getMarca(),
            $request->getModelo(),
            $request->getVersion(),
            $request->getColor(),
            $request->getNumPuestos(),
            $request->getNumPuertas(),
            $request->getCombustible(),
            $request->getKilometros(),
            $request->getCilindraje(),
            $request->getCategoria()
        );
    }

    public function fromUpdateRequestToCommand(
        UpdateVehiculoWebRequest $request
    ): UpdateVehiculoCommand {
        return new UpdateVehiculoCommand(
            $request->getPlaca(),
            $request->getMarca(),
            $request->getModelo(),
            $request->getVersion(),
            $request->getColor(),
            $request->getNumPuestos(),
            $request->getNumPuertas(),
            $request->getCombustible(),
            $request->getKilometros(),
            $request->getCilindraje(),
            $request->getCategoria()
        );
    }

    public function fromPlacaToGetByPlacaQuery(
        string $placa
    ): GetVehiculoByPlacaQuery {
        return new GetVehiculoByPlacaQuery($placa);
    }

    public function fromPlacaToDeleteCommand(
        string $placa
    ): DeleteVehiculoCommand {
        return new DeleteVehiculoCommand($placa);
    }

    public function fromModelToResponse(
        VehiculoModel $vehiculo
    ): VehiculoResponse {
        return new VehiculoResponse(
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

    /**
     * @param VehiculoModel[] $vehiculos
     * @return VehiculoResponse[]
     */
    public function fromModelsToResponses(array $vehiculos): array
    {
        $responses = array();

        foreach ($vehiculos as $vehiculo) {
            $responses[] = $this->fromModelToResponse($vehiculo);
        }

        return $responses;
    }
}