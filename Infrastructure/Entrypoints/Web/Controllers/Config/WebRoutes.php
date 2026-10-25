<?php

declare(strict_types=1);

final class WebRoutes
{
    /**
     * @return array<string, array<string, string>>
     */
    public static function routes(): array
    {
        return array(
            // Home
            'home' => array(
                'method' => 'GET',
                'action' => 'home',
            ),

            // Users CRUD
            'users.create' => array(
                'method' => 'GET',
                'action' => 'create',
            ),
            'users.store' => array(
                'method' => 'POST',
                'action' => 'store',
            ),
            'users.index' => array(
                'method' => 'GET',
                'action' => 'index',
            ),
            'users.show' => array(
                'method' => 'GET',
                'action' => 'show',
            ),
            'users.edit' => array(
                'method' => 'GET',
                'action' => 'edit',
            ),
            'users.update' => array(
                'method' => 'POST',
                'action' => 'update',
            ),
            'users.delete' => array(
                'method' => 'POST',
                'action' => 'delete',
            ),

            // Vehicles CRUD
            'vehiculos.create' => array(
                'method' => 'GET',
                'action' => 'create',
            ),
            'vehiculos.store' => array(
                'method' => 'POST',
                'action' => 'store',
            ),
            'vehiculos.index' => array(
                'method' => 'GET',
                'action' => 'index',
            ),
            'vehiculos.show' => array(
                'method' => 'GET',
                'action' => 'show',
            ),
            'vehiculos.edit' => array(
                'method' => 'GET',
                'action' => 'edit',
            ),
            'vehiculos.update' => array(
                'method' => 'POST',
                'action' => 'update',
            ),
            'vehiculos.delete' => array(
                'method' => 'POST',
                'action' => 'delete',
            ),

            // Authentication
            'auth.login' => array(
                'method' => 'GET',
                'action' => 'login',
            ),
            'auth.authenticate' => array(
                'method' => 'POST',
                'action' => 'authenticate',
            ),
            'auth.logout' => array(
                'method' => 'GET',
                'action' => 'logout',
            ),

            // Password recovery
            'auth.forgot' => array(
                'method' => 'GET',
                'action' => 'forgot',
            ),
            'auth.forgot.send' => array(
                'method' => 'POST',
                'action' => 'forgot.send',
            ),
            'auth.reset' => array(
                'method' => 'GET',
                'action' => 'reset',
            ),
            'auth.reset.submit' => array(
                'method' => 'POST',
                'action' => 'reset.submit',
            ),
        );
    }
}