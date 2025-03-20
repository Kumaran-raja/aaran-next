<?php

namespace Aaran\Core\Tenant\Services;

use Illuminate\Support\Facades\DB;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Config;

class TenantService
{
    /**
     * Switch the database connection to the tenant's database.
     *
     * @param Tenant $tenant
     * @return void
     */
    public function switchDatabase(Tenant $tenant): void
    {
        // Set tenant-specific database connection
        Config::set("database.connections.tenant", [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => env('DB_PORT', '3306'),
            'database'  => $tenant->database_name,
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ]);

        // Switch the default database connection to 'tenant'
        DB::purge('tenant');  // Clears existing connections
        DB::setDefaultConnection('tenant');
    }
}

