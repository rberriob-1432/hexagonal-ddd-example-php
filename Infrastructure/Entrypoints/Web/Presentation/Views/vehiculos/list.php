<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Lista de vehículos</h1>

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

<p>
    <a class="btn btn-primary" href="?route=vehiculos.create">
        Registrar vehículo
    </a>
</p>

<?php if (empty($vehiculos)): ?>
    <p>No hay vehículos registrados todavía.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Versión</th>
                <th>Color</th>
                <th>Categoría</th>
                <th>Kilómetros</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehiculos as $vehiculo): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($vehiculo->getPlaca(), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($vehiculo->getMarca(), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($vehiculo->getModelo(), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($vehiculo->getVersion(), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($vehiculo->getColor(), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($vehiculo->getCategoria(), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td>
                        <?= number_format($vehiculo->getKilometros(), 0, ',', '.') ?>
                    </td>
                    <td class="col-actions">
                        <a class="btn btn-sm"
                           href="?route=vehiculos.show&amp;placa=<?= urlencode($vehiculo->getPlaca()) ?>">
                            Ver
                        </a>

                        <a class="btn btn-warning btn-sm"
                           href="?route=vehiculos.edit&amp;placa=<?= urlencode($vehiculo->getPlaca()) ?>">
                            Editar
                        </a>

                        <form method="POST"
                              action="?route=vehiculos.delete"
                              style="display:inline;"
                              onsubmit="return confirmDelete(this);"
                              data-name="<?= htmlspecialchars($vehiculo->getPlaca(), ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden"
                                   name="placa"
                                   value="<?= htmlspecialchars($vehiculo->getPlaca(), ENT_QUOTES, 'UTF-8') ?>">

                            <button type="submit" class="btn btn-danger btn-sm">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>