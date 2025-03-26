<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Default Roles
    |--------------------------------------------------------------------------
    |
    | Define the default roles available in the system.
    | These roles are assigned based on business logic.
    |
    */

    'roles' => [
        'super_admin' => [
            'name' => 'Super Admin',
            'permissions' => ['*'], // Full access to everything
        ],
        'admin' => [
            'name' => 'Admin',
            'permissions' => [
                'manage_users',
                'manage_roles',
                'view_reports',
                'configure_settings',
            ],
        ],
        'user' => [
            'name' => 'User',
            'permissions' => [
                'view_dashboard',
                'edit_profile',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Permissions
    |--------------------------------------------------------------------------
    |
    | Define the available permissions that can be assigned to roles.
    |
    */

    'permissions' => [
        'manage_users' => 'Create, update, and delete users',
        'manage_roles' => 'Assign and modify user roles',
        'view_reports' => 'Access system reports',
        'configure_settings' => 'Modify system settings',
        'view_dashboard' => 'Access dashboard',
        'edit_profile' => 'Update personal profile information',
    ],

    /*
    |--------------------------------------------------------------------------
    | Role-Based Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Define authentication guards to separate role-based authentication.
    |
    */

    'guards' => [
        'super_admin' => 'super_admin',
        'admin' => 'admin',
        'user' => 'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Caching role-based permissions to improve performance.
    |
    */

    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // Cache expiration time in seconds (1 hour)
    ],
];

