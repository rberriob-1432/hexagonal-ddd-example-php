<?php

declare(strict_types=1);

final class Flash
{
    private const SESSION_KEY = '_flash';
    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void
    {
        self::start();

        $_SESSION[self::SESSION_KEY][$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();

        if (!isset($_SESSION[self::SESSION_KEY][$key])) {
            return $default;
        }

        $value = $_SESSION[self::SESSION_KEY][$key];

        unset($_SESSION[self::SESSION_KEY][$key]);

        if ($_SESSION[self::SESSION_KEY] === []) {
            unset($_SESSION[self::SESSION_KEY]);
        }

        return $value;
    }

    /**
     * @param array<string, string> $data
     */
    public static function setOld(array $data): void
    {
        self::set('old', $data);
    }

    /**
     * @return array<string, string>
     */
    public static function old(): array
    {
        $data = self::get('old', []);

        if (!is_array($data)) {
            return [];
        }

        $result = [];

        foreach ($data as $key => $value) {
            if (is_string($key) && is_string($value)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * @param array<string, string> $errors
     */
    public static function setErrors(array $errors): void
    {
        self::set('errors', $errors);
    }

    /**
     * @return array<string, string>
     */
    public static function errors(): array
    {
        $errors = self::get('errors', []);

        if (!is_array($errors)) {
            return [];
        }

        $result = [];

        foreach ($errors as $key => $value) {
            if (is_string($key) && is_string($value)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public static function setMessage(string $message): void
    {
        self::set('message', $message);
    }

    public static function message(): string
    {
        $message = self::get('message', '');

        return is_string($message) ? $message : '';
    }

    public static function setSuccess(string $message): void
    {
        self::set('success', $message);
    }

    public static function success(): string
    {
        $message = self::get('success', '');

        return is_string($message) ? $message : '';
    }
}