<?php

declare(strict_types=1);

final class ClassLoader
{
    /**
     * @var array<string, string>
     */
    private static array $classMap = array(
        // ──────────────────────────────────────────────────────
        // Domain: User exceptions
        // ──────────────────────────────────────────────────────

        'InvalidUserEmailException' => 'Domain/Exceptions/InvalidUserEmailException.php',
        'InvalidUserIdException' => 'Domain/Exceptions/InvalidUserIdException.php',
        'InvalidUserNameException' => 'Domain/Exceptions/InvalidUserNameException.php',
        'InvalidUserPasswordException' => 'Domain/Exceptions/InvalidUserPasswordException.php',
        'InvalidUserRoleException' => 'Domain/Exceptions/InvalidUserRoleException.php',
        'InvalidUserStatusException' => 'Domain/Exceptions/InvalidUserStatusException.php',
        'UserAlreadyExistsException' => 'Domain/Exceptions/UserAlreadyExistsException.php',
        'UserNotFoundException' => 'Domain/Exceptions/UserNotFoundException.php',
        'InvalidCredentialsException' => 'Domain/Exceptions/InvalidCredentialsException.php',

        // Domain: Vehicle exceptions
        'VehiculoYaExisteExcepcion' => 'Domain/Exceptions/VehiculoYaExisteExcepcion.php',
        'VehiculoNoEncontradoExcepcion' => 'Domain/Exceptions/VehiculoNoEncontradoExcepcion.php',
        'VehiculoPlacaInvalidaExcepcion' => 'Domain/Exceptions/VehiculoPlacaInvalidaExcepcion.php',
        'VehiculoMarcaInvalidaExcepcion' => 'Domain/Exceptions/VehiculoMarcaInvalidaExcepcion.php',
        'VehiculoModeloInvalidoExcepcion' => 'Domain/Exceptions/VehiculoModeloInvalidoExcepcion.php',
        'VehiculoVersionInvalidaExcepcion' => 'Domain/Exceptions/VehiculoVersionInvalidaExcepcion.php',
        'VehiculoColorInvalidoExcepcion' => 'Domain/Exceptions/VehiculoColorInvalidaExcepcion.php',
        'VehiculoNumPuestosInvalidoExcepcion' => 'Domain/Exceptions/VehiculoNumPuestosInvalidoExcepcion.php',
        'VehiculoNumPuertasInvalidoExcepcion' => 'Domain/Exceptions/VehiculoNumPuertasInvalidoExcepcion.php',
        'VehiculoCombustibleInvalidoExcepcion' => 'Domain/Exceptions/VehiculoCombustibleInvalidoExcepcion.php',
        'VehiculoKilometrosInvalidosExcepcion' => 'Domain/Exceptions/VehiculoKilometrosInvalidosExcepcion.php',
        'VehiculoCilindrajeInvalidoExcepcion' => 'Domain/Exceptions/VehiculoCilindrajeInvalidoExcepcion.php',
        'VehiculoCategoriaInvalidaExcepcion' => 'Domain/Exceptions/VehiculoCategoriaInvalidaExcepcion.php',

        // Domain: Enums
        'UserRoleEnum' => 'Domain/Enums/UserRoleEnum.php',
        'UserStatusEnum' => 'Domain/Enums/UserStatusEnum.php',
        'VehiculoCombustibleEnum' => 'Domain/Enums/VehiculoCombustibleEnum.php',
        'VehiculoCategoriaEnum' => 'Domain/Enums/VehiculoCategoriaEnum.php',

        // Domain: User value objects
        'UserId' => 'Domain/ValueObjects/UserId.php',
        'UserName' => 'Domain/ValueObjects/UserName.php',
        'UserEmail' => 'Domain/ValueObjects/UserEmail.php',
        'UserPassword' => 'Domain/ValueObjects/UserPassword.php',

        // Domain: Vehicle value objects
        'VehiculoPlaca' => 'Domain/ValueObjects/VehiculoPlaca.php',
        'VehiculoMarca' => 'Domain/ValueObjects/VehiculoMarca.php',
        'VehiculoModelo' => 'Domain/ValueObjects/VehiculoModelo.php',
        'VehiculoVersion' => 'Domain/ValueObjects/VehiculoVersion.php',
        'VehiculoColor' => 'Domain/ValueObjects/VehiculoColor.php',
        'VehiculoNumPuestos' => 'Domain/ValueObjects/VehiculoNumPuestos.php',
        'VehiculoNumPuertas' => 'Domain/ValueObjects/VehiculoNumPuertas.php',
        'VehiculoCombustible' => 'Domain/ValueObjects/VehiculoCombustible.php',
        'VehiculoKilometros' => 'Domain/ValueObjects/VehiculoKilometros.php',
        'VehiculoCilindraje' => 'Domain/ValueObjects/VehiculoCilindraje.php',
        'VehiculoCategoria' => 'Domain/ValueObjects/VehiculoCategoria.php',

        // Domain: Models and events
        'UserModel' => 'Domain/Models/UserModel.php',
        'VehiculoModel' => 'Domain/Models/VehiculoModel.php',
        'VehiculoCreatedDomainEvent' => 'Domain/Events/VehiculoCreatedDomainEvent.php',
        'VehiculoUpdatedDomainEvent' => 'Domain/Events/VehiculoUpdatedDomainEvent.php',
        'VehiculoDeletedDomainEvent' => 'Domain/Events/VehiculoDeletedDomainEvent.php',

        // Domain: Email
        'EmailDestinationModel' => 'Domain/Models/EmailDestinationModel.php',
        'EmailSenderException' => 'Domain/Exceptions/EmailSenderException.php',

        // ──────────────────────────────────────────────────────
        // Application: Email
        // ──────────────────────────────────────────────────────

        'EmailSenderPort' => 'Application/Ports/Out/EmailSenderPort.php',
        'EmailNotificationService' => 'Application/Services/EmailNotificationService.php',

        // ──────────────────────────────────────────────────────
        // Infrastructure: Email
        // ──────────────────────────────────────────────────────

        'EmailSenderService' => 'Infrastructure/Adapters/Email/EmailSenderService.php',
        'PasswordRecoveryService' => 'Infrastructure/Adapters/Email/PasswordRecoveryService.php',

        // ──────────────────────────────────────────────────────
        // Application: User input ports
        // ──────────────────────────────────────────────────────

        'CreateUserUseCase' => 'Application/Ports/In/CreateUserUseCase.php',
        'UpdateUserUseCase' => 'Application/Ports/In/UpdateUserUseCase.php',
        'GetUserByIdUseCase' => 'Application/Ports/In/GetUserByIdUseCase.php',
        'GetAllUsersUseCase' => 'Application/Ports/In/GetAllUsersUseCase.php',
        'DeleteUserUseCase' => 'Application/Ports/In/DeleteUserUseCase.php',
        'LoginUseCase' => 'Application/Ports/In/LoginUseCase.php',

        // Application: User output ports
        'SaveUserPort' => 'Application/Ports/Out/SaveUserPort.php',
        'UpdateUserPort' => 'Application/Ports/Out/UpdateUserPort.php',
        'GetUserByIdPort' => 'Application/Ports/Out/GetUserByIdPort.php',
        'GetUserByEmailPort' => 'Application/Ports/Out/GetUserByEmailPort.php',
        'GetAllUsersPort' => 'Application/Ports/Out/GetAllUsersPort.php',
        'DeleteUserPort' => 'Application/Ports/Out/DeleteUserPort.php',

        // Application: User DTOs
        'CreateUserCommand' => 'Application/Services/Dto/Commands/CreateUserCommand.php',
        'UpdateUserCommand' => 'Application/Services/Dto/Commands/UpdateUserCommand.php',
        'DeleteUserCommand' => 'Application/Services/Dto/Commands/DeleteUserCommand.php',
        'LoginCommand' => 'Application/Services/Dto/Commands/LoginCommand.php',
        'GetUserByIdQuery' => 'Application/Services/Dto/Queries/GetUserByIdQuery.php',
        'GetAllUsersQuery' => 'Application/Services/Dto/Queries/GetAllUsersQuery.php',

        // Application: User services and mapper
        'CreateUserService' => 'Application/Services/CreateUserService.php',
        'UpdateUserService' => 'Application/Services/UpdateUserService.php',
        'GetUserByIdService' => 'Application/Services/GetUserByIdService.php',
        'GetAllUsersService' => 'Application/Services/GetAllUsersService.php',
        'DeleteUserService' => 'Application/Services/DeleteUserService.php',
        'LoginService' => 'Application/Services/LoginService.php',
        'UserApplicationMapper' => 'Application/Services/Mappers/UserApplicationMapper.php',

        // ──────────────────────────────────────────────────────
        // Application: Vehicle input ports
        // ──────────────────────────────────────────────────────

        'CreateVehiculoUseCase' => 'Application/Ports/In/CreateVehiculoUseCase.php',
        'UpdateVehiculoUseCase' => 'Application/Ports/In/UpdateVehiculoUseCase.php',
        'GetVehiculoByPlacaUseCase' => 'Application/Ports/In/GetVehiculoByPlacaUseCase.php',
        'GetAllVehiculosUseCase' => 'Application/Ports/In/GetAllVehiculosUseCase.php',
        'DeleteVehiculoUseCase' => 'Application/Ports/In/DeleteVehiculoUseCase.php',

        // Application: Vehicle output ports
        'SaveVehiculoPort' => 'Application/Ports/Out/SaveVehiculoPort.php',
        'UpdateVehiculoPort' => 'Application/Ports/Out/UpdateVehiculoPort.php',
        'GetVehiculoByPlacaPort' => 'Application/Ports/Out/GetVehiculoByPlacaPort.php',
        'GetAllVehiculosPort' => 'Application/Ports/Out/GetAllVehiculosPort.php',
        'DeleteVehiculoPort' => 'Application/Ports/Out/DeleteVehiculoPort.php',

        // Application: Vehicle DTOs
        'CreateVehiculoCommand' => 'Application/Services/Dto/Commands/CreateVehiculoCommand.php',
        'UpdateVehiculoCommand' => 'Application/Services/Dto/Commands/UpdateVehiculoCommand.php',
        'DeleteVehiculoCommand' => 'Application/Services/Dto/Commands/DeleteVehiculoCommand.php',
        'GetVehiculoByPlacaQuery' => 'Application/Services/Dto/Queries/GetVehiculoByPlacaQuery.php',
        'GetAllVehiculosQuery' => 'Application/Services/Dto/Queries/GetAllVehiculosQuery.php',

        // Application: Vehicle services and mapper
        'CreateVehiculoService' => 'Application/Services/CreateVehiculoService.php',
        'UpdateVehiculoService' => 'Application/Services/UpdateVehiculoService.php',
        'GetVehiculoByPlacaService' => 'Application/Services/GetVehiculoByPlacaService.php',
        'GetAllVehiculosService' => 'Application/Services/GetAllVehiculosService.php',
        'DeleteVehiculoService' => 'Application/Services/DeleteVehiculoService.php',
        'VehiculoApplicationMapper' => 'Application/Services/Mappers/VehiculoApplicationMapper.php',

        // ──────────────────────────────────────────────────────
        // Infrastructure: Database and user persistence
        // ──────────────────────────────────────────────────────

        'Connection' => 'Infrastructure/Adapters/Persistence/MySQL/Config/Connection.php',
        'UserPersistenceDto' => 'Infrastructure/Adapters/Persistence/MySQL/Dto/UserPersistenceDto.php',
        'UserEntity' => 'Infrastructure/Adapters/Persistence/MySQL/Entity/UserEntity.php',
        'UserPersistenceMapper' => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/UserPersistenceMapper.php',
        'UserRepositoryMySQL' => 'Infrastructure/Adapters/Persistence/MySQL/Repository/UserRepositoryMySQL.php',

        // Infrastructure: Vehicle persistence
        'VehiculoPersistenceDto' => 'Infrastructure/Adapters/Persistence/MySQL/Dto/VehiculoPersistenceDto.php',
        'VehiculoEntity' => 'Infrastructure/Adapters/Persistence/MySQL/Entity/VehiculoEntity.php',
        'VehiculoPersistenceMapper' => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/VehiculoPersistenceMapper.php',
        'VehiculoRepositoryMySQL' => 'Infrastructure/Adapters/Persistence/MySQL/Repository/VehiculoRepositoryMySQL.php',

        // ──────────────────────────────────────────────────────
        // Infrastructure: User web entrypoints
        // ──────────────────────────────────────────────────────

        'CreateUserWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/CreateUserRequest.php',
        'UpdateUserWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UpdateUserRequest.php',
        'LoginWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/LoginWebRequest.php',
        'UserResponse' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UserResponse.php',
        'UserWebMapper' => 'Infrastructure/Entrypoints/Web/Controllers/Mapper/UserWebMapper.php',
        'UserController' => 'Infrastructure/Entrypoints/Web/Controllers/UserController.php',

        // Infrastructure: Vehicle web entrypoints
        'CreateVehiculoWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/CreateVehiculoWebRequest.php',
        'UpdateVehiculoWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UpdateVehiculoWebRequest.php',
        'VehiculoResponse' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/VehiculoResponse.php',
        'VehiculoWebMapper' => 'Infrastructure/Entrypoints/Web/Controllers/Mapper/VehiculoWebMapper.php',
        'VehiculoController' => 'Infrastructure/Entrypoints/Web/Controllers/VehiculoController.php',

        // ──────────────────────────────────────────────────────
        // Infrastructure: Web configuration and presentation
        // ──────────────────────────────────────────────────────

        'WebRoutes' => 'Infrastructure/Entrypoints/Web/Controllers/Config/WebRoutes.php',
        'View' => 'Infrastructure/Entrypoints/Web/Presentation/View.php',
        'Flash' => 'Infrastructure/Entrypoints/Web/Presentation/Flash.php',

        // ──────────────────────────────────────────────────────
        // Common
        // ──────────────────────────────────────────────────────

        'DependencyInjection' => 'Common/DependencyInjection.php',
    );

    public static function register(): void
    {
        spl_autoload_register(array(self::class, 'loadClass'));
    }

    public static function loadClass(string $className): void
    {
        if (!isset(self::$classMap[$className])) {
            return;
        }

        $baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        $filePath = $baseDir . self::$classMap[$className];

        if (!file_exists($filePath)) {
            throw new RuntimeException(
                sprintf(
                    'No se encontró el archivo para la clase %s en %s',
                    $className,
                    $filePath
                )
            );
        }

        require_once $filePath;
    }
}
