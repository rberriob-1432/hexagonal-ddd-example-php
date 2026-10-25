<?php

declare(strict_types=1);

// Guardia de seguridad: bloquear accesos fuera de public/.
(function (): void {
    $requestPath = rtrim(
        (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH),
        '/'
    );

    $publicBase = rtrim(
        dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php')),
        '/'
    );

    if (
        $requestPath !== $publicBase
        && !str_starts_with($requestPath, $publicBase . '/')
    ) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $dest = isset($_SESSION['auth']['id']) ? 'home' : 'auth.login';

        header('Location: ' . $publicBase . '/index.php?route=' . $dest);
        exit;
    }
})();

require_once __DIR__ . '/../Common/ClassLoader.php';
require_once __DIR__ . '/../Common/DependencyInjection.php';
require_once __DIR__ . '/../Infrastructure/Entrypoints/Web/Presentation/View.php';
require_once __DIR__ . '/../Infrastructure/Entrypoints/Web/Presentation/Flash.php';

DependencyInjection::boot();
Flash::start();

// ------------------------------------------------------------
// Auth helpers
// ------------------------------------------------------------

function isLoggedIn(): bool
{
    return isset($_SESSION['auth']['id']);
}

function requireAuth(): void
{
    if (!isLoggedIn()) {
        Flash::setMessage('Debes iniciar sesión para acceder a esta sección.');
        View::redirect('auth.login');
    }
}

function getLoggedUser(): array
{
    return is_array($_SESSION['auth'] ?? null)
        ? $_SESSION['auth']
        : array();
}

// ------------------------------------------------------------
// Routing
// ------------------------------------------------------------

$route = isset($_GET['route'])
    ? trim((string) $_GET['route'])
    : 'home';

$routes = WebRoutes::routes();

if (!isset($routes[$route])) {
    http_response_code(404);
    View::render('home', buildHomeViewData('Ruta no encontrada.'));
    exit;
}

$definition = $routes[$route];
$httpMethod = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));

if ($httpMethod !== $definition['method']) {
    http_response_code(405);
    View::render('home', buildHomeViewData('Método HTTP no permitido.'));
    exit;
}

// Rutas públicas. Se comprueba la ruta completa, no la acción genérica.
$publicRoutes = array(
    'home',
    'auth.login',
    'auth.authenticate',
    'auth.logout',
    'auth.forgot',
    'auth.forgot.send',
    'auth.reset',
    'auth.reset.submit',
    'users.create',
    'users.store',
);

if (
    !in_array($route, $publicRoutes, true)
    && !isLoggedIn()
) {
    Flash::setMessage('Debes iniciar sesión para acceder a esta sección.');
    View::redirect('auth.login');
}

try {
    // --------------------------------------------------------
    // Vehicles CRUD
    // Se despacha por ruta completa para evitar conflictos
    // con las acciones del CRUD de usuarios.
    // --------------------------------------------------------

    if (str_starts_with($route, 'vehiculos.')) {
        switch ($route) {
            case 'vehiculos.index':
                $controller = DependencyInjection::getVehiculoController();
                $vehiculos = $controller->index();

                View::render('vehiculos/list', array(
                    'pageTitle' => 'Lista de vehículos',
                    'vehiculos' => $vehiculos,
                    'message' => Flash::message(),
                    'success' => Flash::success(),
                ));
                exit;

            case 'vehiculos.create':
                View::render('vehiculos/create', array(
                    'pageTitle' => 'Registrar vehículo',
                    'message' => Flash::message(),
                    'success' => Flash::success(),
                    'errors' => Flash::errors(),
                    'old' => Flash::old(),
                ));
                exit;

            case 'vehiculos.store':
                $form = getVehiculoFormData();

                $errors = validateVehiculoForm($form);

                if (!empty($errors)) {
                    Flash::setOld($form);
                    Flash::setErrors($errors);
                    Flash::setMessage('Corrige los errores del formulario.');
                    View::redirect('vehiculos.create');
                }

                $controller = DependencyInjection::getVehiculoController();

                $request = new CreateVehiculoWebRequest(
                    $form['placa'],
                    $form['marca'],
                    $form['modelo'],
                    $form['version'],
                    $form['color'],
                    (int) $form['num_puestos'],
                    (int) $form['num_puertas'],
                    $form['combustible'],
                    (int) $form['kilometros'],
                    (int) $form['cilindraje'],
                    $form['categoria']
                );

                $controller->store($request);

                Flash::setSuccess('Vehículo registrado correctamente.');
                View::redirect('vehiculos.index');
                break;

            case 'vehiculos.show':
                $controller = DependencyInjection::getVehiculoController();
                $placa = trim((string) ($_GET['placa'] ?? ''));
                $vehiculo = $controller->show($placa);

                View::render('vehiculos/show', array(
                    'pageTitle' => 'Detalle del vehículo',
                    'vehiculo' => $vehiculo,
                    'message' => Flash::message(),
                    'success' => Flash::success(),
                ));
                exit;

            case 'vehiculos.edit':
                $controller = DependencyInjection::getVehiculoController();
                $placa = trim((string) ($_GET['placa'] ?? ''));
                $vehiculo = $controller->show($placa);

                View::render('vehiculos/edit', array(
                    'pageTitle' => 'Editar vehículo',
                    'vehiculo' => $vehiculo,
                    'message' => Flash::message(),
                    'errors' => Flash::errors(),
                    'old' => Flash::old(),
                ));
                exit;

            case 'vehiculos.update':
                $form = getVehiculoFormData();

                $errors = validateVehiculoForm($form);

                if (!empty($errors)) {
                    Flash::setOld($form);
                    Flash::setErrors($errors);
                    Flash::setMessage('Corrige los errores del formulario.');

                    header(
                        'Location: ?route=vehiculos.edit&placa='
                        . urlencode($form['placa'])
                    );
                    exit;
                }

                $controller = DependencyInjection::getVehiculoController();

                $request = new UpdateVehiculoWebRequest(
                    $form['placa'],
                    $form['marca'],
                    $form['modelo'],
                    $form['version'],
                    $form['color'],
                    (int) $form['num_puestos'],
                    (int) $form['num_puertas'],
                    $form['combustible'],
                    (int) $form['kilometros'],
                    (int) $form['cilindraje'],
                    $form['categoria']
                );

                $controller->update($request);

                Flash::setSuccess('Vehículo actualizado correctamente.');
                View::redirect('vehiculos.index');
                break;

            case 'vehiculos.delete':
                $placa = trim((string) ($_POST['placa'] ?? ''));

                if ($placa === '') {
                    Flash::setMessage('No se recibió la placa del vehículo.');
                    View::redirect('vehiculos.index');
                }

                $controller = DependencyInjection::getVehiculoController();
                $controller->delete($placa);

                Flash::setSuccess('Vehículo eliminado correctamente.');
                View::redirect('vehiculos.index');
                break;

            default:
                throw new RuntimeException(
                    'Ruta de vehículos no soportada: ' . $route
                );
        }

        // Las rutas de vehículos no deben llegar al CRUD de usuarios.
        exit;
    }

    // --------------------------------------------------------
    // Existing routing: Home, users and authentication
    // --------------------------------------------------------

    switch ($definition['action']) {
        case 'home':
            View::render('home', buildHomeViewData());
            break;

        // ----------------------------------------------------
        // Users CRUD
        // ----------------------------------------------------

        case 'create':
            View::render('users/create', buildCreateUserViewData());
            break;

        case 'store':
            $controller = DependencyInjection::getUserController();
            $form = getCreateUserFormData();
            $form['id'] = generateUuid4();

            $errors = validateCreateUserForm($form);

            if (!empty($errors)) {
                Flash::setOld($form);
                Flash::setErrors($errors);
                Flash::setMessage('Corrige los errores del formulario.');
                View::redirect('users.create');
            }

            $request = new CreateUserWebRequest(
                $form['id'],
                $form['name'],
                $form['email'],
                $form['password'],
                $form['role']
            );

            $controller->store($request);

            Flash::setSuccess('Usuario registrado correctamente.');
            View::redirect('users.index');
            break;

        case 'index':
            $controller = DependencyInjection::getUserController();
            $users = $controller->index();

            View::render(
                'users/list',
                buildListUsersViewData($users)
            );
            break;

        case 'show':
            $controller = DependencyInjection::getUserController();
            $id = trim((string) ($_GET['id'] ?? ''));
            $user = $controller->show($id);

            View::render('users/show', array(
                'pageTitle' => 'Detalle de usuario',
                'user' => $user,
                'message' => Flash::message(),
            ));
            break;

        case 'edit':
            $controller = DependencyInjection::getUserController();
            $id = trim((string) ($_GET['id'] ?? ''));
            $user = $controller->show($id);

            View::render(
                'users/edit',
                buildEditUserViewData($user)
            );
            break;

        case 'update':
            $controller = DependencyInjection::getUserController();
            $form = getUpdateUserFormData();
            $errors = validateUpdateUserForm($form);

            if (!empty($errors)) {
                Flash::setOld($form);
                Flash::setErrors($errors);
                Flash::setMessage('Corrige los errores del formulario.');

                header(
                    'Location: ?route=users.edit&id='
                    . urlencode($form['id'])
                );
                exit;
            }

            $request = new UpdateUserWebRequest(
                $form['id'],
                $form['name'],
                $form['email'],
                $form['password'],
                $form['role'],
                $form['status']
            );

            $controller->update($request);

            Flash::setSuccess('Usuario actualizado correctamente.');
            View::redirect('users.index');
            break;

        case 'delete':
            $controller = DependencyInjection::getUserController();
            $id = trim((string) ($_POST['id'] ?? ''));

            $controller->delete($id);

            Flash::setSuccess('Usuario eliminado correctamente.');
            View::redirect('users.index');
            break;

        // ----------------------------------------------------
        // Authentication
        // ----------------------------------------------------

        case 'login':
            if (isLoggedIn()) {
                View::redirect('home');
            }

            View::render('auth/login', array(
                'pageTitle' => 'Iniciar sesión',
                'message' => Flash::message(),
                'errors' => Flash::errors(),
                'old' => Flash::old(),
            ));
            break;

        case 'authenticate':
            $email = trim(
                strtolower((string) ($_POST['email'] ?? ''))
            );

            $password = (string) ($_POST['password'] ?? '');
            $authErrors = array();

            if ($email === '') {
                $authErrors['email'] = 'El correo es obligatorio.';
            }

            if ($password === '') {
                $authErrors['password'] = 'La contraseña es obligatoria.';
            }

            if (!empty($authErrors)) {
                Flash::setErrors($authErrors);
                Flash::setOld(array('email' => $email));
                View::redirect('auth.login');
            }

            $loginUseCase = DependencyInjection::getLoginUseCase();
            $command = new LoginCommand($email, $password);
            $user = $loginUseCase->execute($command);

            session_regenerate_id(true);

            $_SESSION['auth'] = array(
                'id' => $user->id()->value(),
                'name' => $user->name()->value(),
                'email' => $user->email()->value(),
                'role' => $user->role(),
            );

            Flash::setSuccess(
                'Bienvenido/a, ' . $user->name()->value() . '.'
            );

            View::redirect('home');
            break;

        case 'logout':
            $_SESSION = array();

            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();

                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params['path'],
                    $params['domain'],
                    $params['secure'],
                    $params['httponly']
                );
            }

            session_destroy();

            header('Location: ?route=auth.login');
            exit;

        // ----------------------------------------------------
        // Password recovery: request link
        // ----------------------------------------------------

        case 'forgot':
            View::render('auth/forgot-password', array(
                'pageTitle' => 'Recuperar contraseña',
                'message' => Flash::message(),
                'success' => Flash::success(),
                'errors' => Flash::errors(),
                'old' => Flash::old(),
            ));
            break;

        case 'forgot.send':
            $forgotEmail = trim(
                strtolower((string) ($_POST['email'] ?? ''))
            );

            if (
                $forgotEmail === ''
                || filter_var(
                    $forgotEmail,
                    FILTER_VALIDATE_EMAIL
                ) === false
            ) {
                Flash::setErrors(array(
                    'email' => 'Introduce un correo electrónico válido.',
                ));

                Flash::setOld(array('email' => $forgotEmail));
                Flash::setMessage('Corrige el correo electrónico.');

                View::redirect('auth.forgot');
            }

            DependencyInjection::getPasswordRecoveryService()
                ->requestReset($forgotEmail);

            Flash::setSuccess(
                'Si el correo está registrado y la cuenta está activa, '
                . 'recibirás un enlace para restablecer la contraseña.'
            );

            View::redirect('auth.forgot');
            break;

        // ----------------------------------------------------
        // Password recovery: show reset form
        // ----------------------------------------------------

        case 'reset':
            $token = trim((string) ($_GET['token'] ?? ''));

            $recoveryService =
                DependencyInjection::getPasswordRecoveryService();

            $validToken = $recoveryService->isTokenValid($token);

            View::render('auth/reset-password', array(
                'pageTitle' => 'Crear nueva contraseña',
                'token' => $validToken ? $token : '',
                'message' => $validToken
                    ? Flash::message()
                    : 'El enlace no es válido o ha caducado.',
                'success' => null,
                'errors' => array(),
            ));
            break;

        // ----------------------------------------------------
        // Password recovery: submit new password
        // ----------------------------------------------------

        case 'reset.submit':
            $token = trim((string) ($_POST['token'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');
            $confirmation = (string) (
                $_POST['password_confirmation'] ?? ''
            );

            $recoveryService =
                DependencyInjection::getPasswordRecoveryService();

            if (!$recoveryService->isTokenValid($token)) {
                View::render('auth/reset-password', array(
                    'pageTitle' => 'Crear nueva contraseña',
                    'token' => '',
                    'message' =>
                        'El enlace no es válido o ha caducado. Solicita uno nuevo.',
                    'success' => null,
                    'errors' => array(),
                ));
                break;
            }

            $errors = array();

            if (trim($password) === '' || strlen(trim($password)) < 8) {
                $errors['password'] =
                    'La contraseña debe tener al menos 8 caracteres.';
            }

            if ($password !== $confirmation) {
                $errors['password_confirmation'] =
                    'Las contraseñas no coinciden.';
            }

            if (!empty($errors)) {
                View::render('auth/reset-password', array(
                    'pageTitle' => 'Crear nueva contraseña',
                    'token' => $token,
                    'message' => 'Corrige los errores del formulario.',
                    'success' => null,
                    'errors' => $errors,
                ));
                break;
            }

            $changed = $recoveryService->resetPassword(
                $token,
                $password
            );

            if (!$changed) {
                View::render('auth/reset-password', array(
                    'pageTitle' => 'Crear nueva contraseña',
                    'token' => '',
                    'message' =>
                        'El enlace ya se utilizó o ha caducado. Solicita uno nuevo.',
                    'success' => null,
                    'errors' => array(),
                ));
                break;
            }

            Flash::setSuccess(
                'Tu contraseña se cambió correctamente. Ya puedes iniciar sesión.'
            );

            View::redirect('auth.login');
            break;

        default:
            throw new RuntimeException('Acción no soportada.');
    }
} catch (Throwable $exception) {
    error_log(
        sprintf(
            '[%s] Ruta %s: %s',
            date('c'),
            $route,
            $exception->getMessage()
        )
    );

    switch ($route) {
        case 'users.store':
            Flash::setMessage(
                'No fue posible registrar el usuario. Revisa los datos e inténtalo de nuevo.'
            );
            Flash::setOld(getCreateUserFormData());
            View::redirect('users.create');
            break;

        case 'users.update':
            Flash::setMessage('No fue posible actualizar el usuario.');
            Flash::setOld(getUpdateUserFormData());

            $updateId = trim((string) ($_POST['id'] ?? ''));

            header(
                'Location: ?route=users.edit&id=' . urlencode($updateId)
            );
            exit;

        case 'auth.authenticate':
            Flash::setMessage(
                'No fue posible iniciar sesión. Comprueba tus credenciales.'
            );

            Flash::setOld(array(
                'email' => trim(
                    strtolower((string) ($_POST['email'] ?? ''))
                ),
            ));

            View::redirect('auth.login');
            break;

        case 'auth.forgot.send':
            Flash::setMessage(
                'No fue posible procesar la solicitud. Inténtalo de nuevo más tarde.'
            );

            Flash::setOld(array(
                'email' => trim((string) ($_POST['email'] ?? '')),
            ));

            View::redirect('auth.forgot');
            break;

        case 'auth.reset.submit':
            Flash::setMessage(
                'No fue posible cambiar la contraseña. Solicita un nuevo enlace si es necesario.'
            );

            View::redirect('auth.forgot');
            break;

        case 'users.show':
        case 'users.edit':
            Flash::setMessage('No fue posible cargar el usuario.');
            View::redirect('users.index');
            break;

        case 'users.delete':
            Flash::setMessage('No fue posible eliminar el usuario.');
            View::redirect('users.index');
            break;

        case 'vehiculos.store':
            Flash::setMessage(
                'No fue posible registrar el vehículo. Revisa los datos.'
            );
            Flash::setOld($_POST);
            View::redirect('vehiculos.create');
            break;

        case 'vehiculos.update':
            Flash::setMessage('No fue posible actualizar el vehículo.');
            Flash::setOld($_POST);

            header(
                'Location: ?route=vehiculos.edit&placa='
                . urlencode((string) ($_POST['placa'] ?? ''))
            );
            exit;

        case 'vehiculos.show':
        case 'vehiculos.edit':
        case 'vehiculos.delete':
        case 'vehiculos.index':
            Flash::setMessage(
                'No fue posible completar la operación con el vehículo.'
            );
            View::redirect('vehiculos.index');
            break;

        default:
            http_response_code(500);

            View::render(
                'home',
                buildHomeViewData(
                    'Ocurrió un error interno. Revisa el registro de errores de PHP.'
                )
            );
            break;
    }
}

// ------------------------------------------------------------
// View data builders
// ------------------------------------------------------------

/**
 * @param UserResponse[] $users
 * @return array<string, mixed>
 */
function buildListUsersViewData(array $users): array
{
    return array(
        'pageTitle' => 'Lista de usuarios',
        'users' => $users,
        'message' => Flash::message(),
        'success' => Flash::success(),
    );
}

/**
 * @return array<string, mixed>
 */
function buildHomeViewData(string $message = ''): array
{
    return array(
        'pageTitle' => 'Menú principal',
        'message' => $message,
        'success' => Flash::success(),
    );
}

/**
 * @return array<string, mixed>
 */
function buildCreateUserViewData(): array
{
    return array(
        'pageTitle' => 'Registrar usuario',
        'roleOptions' => UserRoleEnum::values(),
        'message' => Flash::message(),
        'success' => Flash::success(),
        'errors' => Flash::errors(),
        'old' => Flash::old(),
    );
}

/**
 * @return array<string, mixed>
 */
function buildEditUserViewData(UserResponse $user): array
{
    return array(
        'pageTitle' => 'Editar usuario',
        'user' => $user,
        'roleOptions' => UserRoleEnum::values(),
        'statusOptions' => UserStatusEnum::values(),
        'message' => Flash::message(),
        'errors' => Flash::errors(),
        'old' => Flash::old(),
    );
}

// ------------------------------------------------------------
// Form helpers and validation
// ------------------------------------------------------------

function generateUuid4(): string
{
    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf(
        '%s%s-%s-%s-%s-%s%s%s',
        str_split(bin2hex($data), 4)
    );
}

/**
 * @return array<string, string>
 */
function getCreateUserFormData(): array
{
    return array(
        'name' => trim((string) ($_POST['name'] ?? '')),
        'email' => trim((string) ($_POST['email'] ?? '')),
        'password' => trim((string) ($_POST['password'] ?? '')),
        'role' => trim((string) ($_POST['role'] ?? '')),
    );
}

/**
 * @return array<string, string>
 */
function getUpdateUserFormData(): array
{
    return array(
        'id' => trim((string) ($_POST['id'] ?? '')),
        'name' => trim((string) ($_POST['name'] ?? '')),
        'email' => trim((string) ($_POST['email'] ?? '')),
        'password' => (string) ($_POST['password'] ?? ''),
        'role' => trim((string) ($_POST['role'] ?? '')),
        'status' => trim((string) ($_POST['status'] ?? '')),
    );
}

/**
 * @return array<string, string>
 */
function getVehiculoFormData(): array
{
    return array(
        'placa' => trim((string) ($_POST['placa'] ?? '')),
        'marca' => trim((string) ($_POST['marca'] ?? '')),
        'modelo' => trim((string) ($_POST['modelo'] ?? '')),
        'version' => trim((string) ($_POST['version'] ?? '')),
        'color' => trim((string) ($_POST['color'] ?? '')),
        'num_puestos' => trim((string) ($_POST['num_puestos'] ?? '')),
        'num_puertas' => trim((string) ($_POST['num_puertas'] ?? '')),
        'combustible' => trim((string) ($_POST['combustible'] ?? '')),
        'kilometros' => trim((string) ($_POST['kilometros'] ?? '')),
        'cilindraje' => trim((string) ($_POST['cilindraje'] ?? '')),
        'categoria' => trim((string) ($_POST['categoria'] ?? '')),
    );
}

/**
 * @param array<string, string> $form
 * @return array<string, string>
 */
function validateCreateUserForm(array $form): array
{
    $errors = array();

    if ($form['name'] === '') {
        $errors['name'] = 'El nombre es obligatorio.';
    }

    if ($form['email'] === '') {
        $errors['email'] = 'El correo es obligatorio.';
    } elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'El correo no tiene un formato válido.';
    }

    if ($form['password'] === '') {
        $errors['password'] = 'La contraseña es obligatoria.';
    } elseif (strlen($form['password']) < 8) {
        $errors['password'] =
            'La contraseña debe tener al menos 8 caracteres.';
    }

    if ($form['role'] === '') {
        $errors['role'] = 'El rol es obligatorio.';
    }

    return $errors;
}

/**
 * @param array<string, string> $form
 * @return array<string, string>
 */
function validateUpdateUserForm(array $form): array
{
    $errors = array();

    if ($form['name'] === '') {
        $errors['name'] = 'El nombre es obligatorio.';
    }

    if ($form['email'] === '') {
        $errors['email'] = 'El correo es obligatorio.';
    } elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'El correo no tiene un formato válido.';
    }

    if ($form['password'] !== '' && strlen($form['password']) < 8) {
        $errors['password'] =
            'La contraseña debe tener al menos 8 caracteres si deseas cambiarla.';
    }

    if ($form['role'] === '') {
        $errors['role'] = 'El rol es obligatorio.';
    }

    if ($form['status'] === '') {
        $errors['status'] = 'El estado es obligatorio.';
    }

    return $errors;
}

/**
 * @param array<string, string> $form
 * @return array<string, string>
 */
function validateVehiculoForm(array $form): array
{
    $errors = array();

    $requiredFields = array(
        'placa' => 'La placa',
        'marca' => 'La marca',
        'modelo' => 'El modelo',
        'version' => 'La versión',
        'color' => 'El color',
        'num_puestos' => 'El número de puestos',
        'num_puertas' => 'El número de puertas',
        'combustible' => 'El combustible',
        'kilometros' => 'El kilometraje',
        'cilindraje' => 'El cilindraje',
        'categoria' => 'La categoría',
    );

    foreach ($requiredFields as $field => $label) {
        if ($form[$field] === '') {
            $errors[$field] = $label . ' es obligatorio.';
        }
    }

    $integerFields = array(
        'num_puestos' => array(
            'label' => 'El número de puestos',
            'minimum' => 1,
        ),
        'num_puertas' => array(
            'label' => 'El número de puertas',
            'minimum' => 1,
        ),
        'kilometros' => array(
            'label' => 'El kilometraje',
            'minimum' => 0,
        ),
        'cilindraje' => array(
            'label' => 'El cilindraje',
            'minimum' => 1,
        ),
    );

    foreach ($integerFields as $field => $rules) {
        if ($form[$field] === '') {
            continue;
        }

        if (filter_var($form[$field], FILTER_VALIDATE_INT) === false) {
            $errors[$field] =
                $rules['label'] . ' debe ser un número entero.';
            continue;
        }

        if ((int) $form[$field] < $rules['minimum']) {
            $errors[$field] = $rules['minimum'] === 0
                ? $rules['label'] . ' no puede ser negativo.'
                : $rules['label'] . ' debe ser mayor que cero.';
        }
    }

    require_once __DIR__ . '/../Domain/Enums/VehiculoCombustibleEnum.php';
    require_once __DIR__ . '/../Domain/Enums/VehiculoCategoriaEnum.php';

    if (
        $form['combustible'] !== ''
        && !VehiculoCombustibleEnum::isValid($form['combustible'])
    ) {
        $errors['combustible'] =
            'El combustible seleccionado no es válido.';
    }

    if (
        $form['categoria'] !== ''
        && !VehiculoCategoriaEnum::isValid($form['categoria'])
    ) {
        $errors['categoria'] =
            'La categoría seleccionada no es válida.';
    }

    return $errors;
}