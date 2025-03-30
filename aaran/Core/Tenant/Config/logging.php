<?php

return [
    'tenant' => [
        'driver' => 'daily',
        'path' => storage_path('logs/tenants/tenant.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'days' => 14,
    ],

];


