<?php

return [
    'database' => [
        'connection' => env('TENANT_DB_CONNECTION', 'mysql'), // Default to MySQL
    ],
    'storage' => [
        'disk' => env('TENANT_STORAGE_DISK', 'local'), // Can be S3, local, etc.
    ],
    'mail' => [
        'driver' => env('TENANT_MAIL_DRIVER', 'smtp'),
        'host' => env('TENANT_MAIL_HOST', 'smtp.example.com'),
        'port' => env('TENANT_MAIL_PORT', 587),
        'username' => env('TENANT_MAIL_USERNAME', null),
        'password' => env('TENANT_MAIL_PASSWORD', null),
        'encryption' => env('TENANT_MAIL_ENCRYPTION', 'tls'),
    ],
    'features' => [
        'allow_custom_domains' => true,
        'max_users' => 100,
    ],
];
