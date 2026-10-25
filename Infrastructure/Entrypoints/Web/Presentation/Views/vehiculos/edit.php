<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Editar vehículo</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <ul class="alert-error">
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
$old = $old ?? [];

$value = static function (string $field, $default = '') use ($old): string {
    return htmlspecialchars(
        (string) ($old[$field] ?? $default),
        ENT_QUOTES,
        'UTF-8'
    );
};

$combustibleActual = strtoupper(
    (string) ($old['combustible'] ?? $vehiculo->getCombustible())
);

$categoriaActual = strtoupper(
    (string) ($old['categoria'] ?? $vehiculo->getCategoria())
);
?>

<form method="POST" action="?route=vehiculos.update">
    <input
        type="hidden"
        name="placa"
        value="<?= $value('placa', $vehiculo->getPlaca()) ?>"
    >

    <div>
        <label for="placa_visible">Placa</label>
        <input
            type="text"
            id="placa_visible"
            value="<?= htmlspecialchars($vehiculo->getPlaca(), ENT_QUOTES, 'UTF-8') ?>"
            disabled
        >
    </div>

    <div>
        <label for="marca">Marca</label>
        <input
            type="text"
            id="marca"
            name="marca"
            value="<?= $value('marca', $vehiculo->getMarca()) ?>"
            required
        >
    </div>

    <div>
        <label for="modelo">Modelo</label>
        <input
            type="text"
            id="modelo"
            name="modelo"
            value="<?= $value('modelo', $vehiculo->getModelo()) ?>"
            required
        >
    </div>

    <div>
        <label for="version">Versión</label>
        <input
            type="text"
            id="version"
            name="version"
            value="<?= $value('version', $vehiculo->getVersion()) ?>"
            required
        >
    </div>

    <div>
        <label for="color">Color</label>
        <input
            type="text"
            id="color"
            name="color"
            value="<?= $value('color', $vehiculo->getColor()) ?>"
            required
        >
    </div>

    <div>
        <label for="num_puestos">Número de puestos</label>
        <input
            type="number"
            id="num_puestos"
            name="num_puestos"
            min="1"
            value="<?= $value('num_puestos', $vehiculo->getNumPuestos()) ?>"
            required
        >
    </div>

    <div>
        <label for="num_puertas">Número de puertas</label>
        <input
            type="number"
            id="num_puertas"
            name="num_puertas"
            min="0"
            value="<?= $value('num_puertas', $vehiculo->getNumPuertas()) ?>"
            required
        >
    </div>

    <div>
        <label for="combustible">Combustible</label>
        <select id="combustible" name="combustible" required>
            <?php foreach (['GASOLINA', 'DIESEL', 'ELECTRICO', 'HIBRIDO', 'GAS'] as $combustible): ?>
                <option
                    value="<?= $combustible ?>"
                    <?= $combustibleActual === $combustible ? 'selected' : '' ?>
                >
                    <?= $combustible ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="kilometros">Kilómetros</label>
        <input
            type="number"
            id="kilometros"
            name="kilometros"
            min="0"
            value="<?= $value('kilometros', $vehiculo->getKilometros()) ?>"
            required
        >
    </div>

    <div>
        <label for="cilindraje">Cilindraje (cc)</label>
        <input
            type="number"
            id="cilindraje"
            name="cilindraje"
            min="0"
            value="<?= $value('cilindraje', $vehiculo->getCilindraje()) ?>"
            required
        >
    </div>

    <div>
        <label for="categoria">Categoría</label>
        <select id="categoria" name="categoria" required>
            <?php foreach (['AUTOMOVIL', 'MOTOCICLETA', 'CAMIONETA', 'CAMION', 'BUS', 'CAMIONETA_CARGA'] as $categoria): ?>
                <option
                    value="<?= $categoria ?>"
                    <?= $categoriaActual === $categoria ? 'selected' : '' ?>
                >
                    <?= str_replace('_', ' ', $categoria) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Guardar cambios
    </button>

    <a
        class="btn"
        href="?route=vehiculos.show&amp;placa=<?= urlencode($vehiculo->getPlaca()) ?>"
    >
        Cancelar
    </a>
</form>