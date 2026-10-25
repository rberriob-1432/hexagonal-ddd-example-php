<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Registrar vehículo</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert-success">
        <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
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

$value = static function (string $field) use ($old): string {
    return htmlspecialchars(
        (string) ($old[$field] ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
};
?>

<form method="POST" action="?route=vehiculos.store">
    <div>
        <label for="placa">Placa</label>
        <input
            type="text"
            id="placa"
            name="placa"
            value="<?= $value('placa') ?>"
            maxlength="20"
            required
        >
    </div>

    <div>
        <label for="marca">Marca</label>
        <input
            type="text"
            id="marca"
            name="marca"
            value="<?= $value('marca') ?>"
            required
        >
    </div>

    <div>
        <label for="modelo">Modelo</label>
        <input
            type="text"
            id="modelo"
            name="modelo"
            value="<?= $value('modelo') ?>"
            required
        >
    </div>

    <div>
        <label for="version">Versión</label>
        <input
            type="text"
            id="version"
            name="version"
            value="<?= $value('version') ?>"
            required
        >
    </div>

    <div>
        <label for="color">Color</label>
        <input
            type="text"
            id="color"
            name="color"
            value="<?= $value('color') ?>"
            required
        >
    </div>

    <div>
        <label for="num_puestos">Número de puestos</label>
        <input
            type="number"
            id="num_puestos"
            name="num_puestos"
            value="<?= $value('num_puestos') ?>"
            min="1"
            required
        >
    </div>

    <div>
        <label for="num_puertas">Número de puertas</label>
        <input
            type="number"
            id="num_puertas"
            name="num_puertas"
            value="<?= $value('num_puertas') ?>"
            min="0"
            required
        >
    </div>

    <div>
        <label for="combustible">Combustible</label>
        <select id="combustible" name="combustible" required>
            <option value="">Selecciona el combustible</option>
            <?php foreach ([
                'GASOLINA',
                'DIESEL',
                'ELECTRICO',
                'HIBRIDO',
                'GAS'
            ] as $combustible): ?>
                <option
                    value="<?= $combustible ?>"
                    <?= strtoupper((string) ($old['combustible'] ?? '')) === $combustible ? 'selected' : '' ?>
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
            value="<?= $value('kilometros') ?>"
            min="0"
            required
        >
    </div>

    <div>
        <label for="cilindraje">Cilindraje (cc)</label>
        <input
            type="number"
            id="cilindraje"
            name="cilindraje"
            value="<?= $value('cilindraje') ?>"
            min="0"
            required
        >
    </div>

    <div>
        <label for="categoria">Categoría</label>
        <select id="categoria" name="categoria" required>
            <option value="">Selecciona la categoría</option>
            <?php foreach ([
                'AUTOMOVIL',
                'MOTOCICLETA',
                'CAMIONETA',
                'CAMION',
                'BUS',
                'CAMIONETA_CARGA'
            ] as $categoria): ?>
                <option
                    value="<?= $categoria ?>"
                    <?= strtoupper((string) ($old['categoria'] ?? '')) === $categoria ? 'selected' : '' ?>
                >
                    <?= str_replace('_', ' ', $categoria) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Registrar vehículo
    </button>

    <a href="?route=vehiculos.index" class="btn">
        Cancelar
    </a>
</form>