<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/EmailDestinationModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/UserPassword.php';
require_once __DIR__ . '/../../../Application/Ports/Out/EmailSenderPort.php';

final class PasswordRecoveryService
{
    public function __construct(
        private PDO $pdo,
        private EmailSenderPort $emailSender,
        private string $appUrl
    ) {
    }

    public function requestReset(string $email): void
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, name, email, status
             FROM users
             WHERE email = :email
             LIMIT 1'
        );

        $stmt->execute([
            'email' => strtolower(trim($email))
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // No revelar si una cuenta existe.
        if (!$user || $user['status'] !== 'ACTIVE') {
            return;
        }

        // Token aleatorio: solo se almacena su hash.
        $token = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $token);

        $this->pdo->beginTransaction();

        try {
            // Solo dejamos vigente un token por usuario.
            $delete = $this->pdo->prepare(
                'DELETE FROM password_reset_tokens
                 WHERE user_id = :user_id'
            );

            $delete->execute([
                'user_id' => $user['id']
            ]);

            $insert = $this->pdo->prepare(
                'INSERT INTO password_reset_tokens
                    (user_id, token_hash, expires_at)
                 VALUES
                    (:user_id, :token_hash,
                     DATE_ADD(NOW(), INTERVAL 30 MINUTE))'
            );

            $insert->execute([
                'user_id' => $user['id'],
                'token_hash' => $tokenHash
            ]);

            $this->pdo->commit();
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }

        $url = rtrim($this->appUrl, '/')
            . '/index.php?route=auth.reset&token='
            . urlencode($token);

        $safeUrl = htmlspecialchars(
            $url,
            ENT_QUOTES,
            'UTF-8'
        );

        $safeName = htmlspecialchars(
            (string) $user['name'],
            ENT_QUOTES,
            'UTF-8'
        );

        $body = "
            <h2>Recuperación de contraseña</h2>
            <p>Hola, {$safeName}.</p>
            <p>Solicitaste restablecer la contraseña de tu cuenta.</p>
            <p>
                <a href=\"{$safeUrl}\">
                    Crear una nueva contraseña
                </a>
            </p>
            <p>El enlace caduca en 30 minutos y solo puede utilizarse una vez.</p>
            <p>Si no solicitaste este cambio, ignora este correo.</p>
        ";

        try {
            $message = new EmailDestinationModel(
                (string) $user['email'],
                (string) $user['name'],
                'Recuperación de contraseña',
                $body
            );

            $this->emailSender->send($message);
        } catch (Throwable $e) {
            // Si falla el correo, eliminar el token recién creado.
            $delete = $this->pdo->prepare(
                'DELETE FROM password_reset_tokens
                 WHERE user_id = :user_id
                   AND token_hash = :token_hash'
            );

            $delete->execute([
                'user_id' => $user['id'],
                'token_hash' => $tokenHash
            ]);

            throw $e;
        }
    }

    public function isTokenValid(string $token): bool
    {
        if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
            return false;
        }

        $stmt = $this->pdo->prepare(
            'SELECT 1
             FROM password_reset_tokens
             WHERE token_hash = :token_hash
               AND expires_at > NOW()
             LIMIT 1'
        );

        $stmt->execute([
            'token_hash' => hash('sha256', $token)
        ]);

        return $stmt->fetchColumn() !== false;
    }

    public function resetPassword(
        string $token,
        string $plainPassword
    ): bool {
        if (!$this->isTokenValid($token)) {
            return false;
        }

        // Valida y cifra la contraseña usando el Value Object existente.
        $password = UserPassword::fromPlainText($plainPassword);

        $this->pdo->beginTransaction();

        try {
            // Bloquear el registro durante el cambio para evitar reutilización.
            $stmt = $this->pdo->prepare(
                'SELECT id, user_id
                 FROM password_reset_tokens
                 WHERE token_hash = :token_hash
                   AND expires_at > NOW()
                 LIMIT 1
                 FOR UPDATE'
            );

            $stmt->execute([
                'token_hash' => hash('sha256', $token)
            ]);

            $reset = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$reset) {
                $this->pdo->rollBack();
                return false;
            }

            // No asumir que la tabla users tiene updated_at.
            $update = $this->pdo->prepare(
                'UPDATE users
                 SET password = :password
                 WHERE id = :user_id
                   AND status = :status'
            );

            $update->execute([
                'password' => $password->value(),
                'user_id' => $reset['user_id'],
                'status' => 'ACTIVE'
            ]);

            if ($update->rowCount() !== 1) {
                $this->pdo->rollBack();
                return false;
            }

            // El token queda consumido.
            $delete = $this->pdo->prepare(
                'DELETE FROM password_reset_tokens
                 WHERE id = :id'
            );

            $delete->execute([
                'id' => $reset['id']
            ]);

            $this->pdo->commit();

            return true;
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }
}