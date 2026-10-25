<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-box">
    <h1>Crear nueva contraseña</h1>

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

    <?php if (!empty($token)): ?>
        <p>La contraseña debe tener al menos 8 caracteres.</p>

        <form method="POST" action="?route=auth.reset.submit">
            <input
                type="hidden"
                name="token"
                value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>"
            >

            <div class="form-group">
                <label for="password">Nueva contraseña</label><br>
                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >

                <?php if (!empty($errors['password'])): ?>
                    <div class="field-error">
                        <?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar contraseña</label><br>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >

                <?php if (!empty($errors['password_confirmation'])): ?>
                    <div class="field-error">
                        <?= htmlspecialchars($errors['password_confirmation'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar nueva contraseña
            </button>
        </form>
    <?php else: ?>
        <p>El enlace no es válido o ha caducado.</p>
        <p>
            <a href="?route=auth.forgot">
                Solicitar otro enlace
            </a>
        </p>
    <?php endif; ?>

    <p style="margin-top: 16px;">
        <a href="?route=auth.login">Volver al inicio de sesión</a>
    </p>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
