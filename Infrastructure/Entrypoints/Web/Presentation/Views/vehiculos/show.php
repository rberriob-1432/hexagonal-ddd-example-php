<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Detalle del vehículo</h1>

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

<?php if (isset($vehiculo)): ?>
    <table>
        <tbody>
            <tr>
                <th>Placa</th>
                <td><?= htmlspecialchars($vehiculo->getPlaca(), ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <th>Marca</th>
                <td><?= htmlspecialchars($vehiculo->getMarca(), ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <th>Modelo</th>
                <td><?= htmlspecialchars($vehiculo->getModelo(), ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <th>Versión</th>
                <td><?= htmlspecialchars($vehiculo->getVersion(), ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <th>Color</th>
                <td><?= htmlspecialchars($vehiculo->getColor(), ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <th>Número de puestos</th>
                <td><?= $vehiculo->getNumPuestos() ?></td>
            </tr>
            <tr>
                <th>Número de puertas</th>
                <td><?= $vehiculo->getNumPuertas() ?></td>
            </tr>
            <tr>
                <th>Combustible</th>
                <td><?= htmlspecialchars($vehiculo->getCombustible(), ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <th>Kilómetros</th>
                <td><?= number_format($vehiculo->getKilometros(), 0, ',', '.') ?></td>
            </tr>
            <tr>
                <th>Cilindraje</th>
                <td><?= number_format($vehiculo->getCilindraje(), 0, ',', '.') ?> cc</td>
            </tr>
            <tr>
                <th>Categoría</th>
                <td><?= htmlspecialchars($vehiculo->getCategoria(), ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        </tbody>
    </table>

    <p>
        <a class="btn btn-warning"
           href="?route=vehiculos.edit&amp;placa=<?= urlencode($vehiculo->getPlaca()) ?>">
            Editar vehículo
        </a>

        <a class="btn" href="?route=vehiculos.index">
            Volver al listado
        </a>
    </p>
<?php else: ?>
    <p>No se encontró información del vehículo.</p>
    <a class="btn" href="?route=vehiculos.index">Volver al listado</a>
<?php endif; ?>