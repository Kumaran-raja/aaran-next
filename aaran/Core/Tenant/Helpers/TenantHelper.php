<?php

namespace Aaran\Core\Tenant\Helpers;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class TenantHelper{

    public static function switchTenant(int $tenantId): bool
    {
        DB::beginTransaction();

        try {

            $tenantConfig = Cache::remember("tenant_{$tenantId}_config", 600, function () use ($tenantId) {
                $tenant = Tenant::findOrFail($tenantId);
                return [
                    'host'      => $tenant->db_host,
                    'port'      => $tenant->db_port,
                    'database'  => $tenant->db_name,
                    'username'  => $tenant->db_user,
                    'password'  => $tenant->db_pass,
                ];
            });

            // Store in session
            Session::put('tenant_db_config', $tenantConfig);

            // Apply the configuration
            self::applyTenantConfig($tenantConfig);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function applyTenantConfig(array $tenantConfig)
    {
        Config::set('database.connections.tenant', [
            'driver'    => 'mysql',
            'host'      => $tenantConfig['host'],
            'port'      => $tenantConfig['port'],
            'database'  => $tenantConfig['database'],
            'username'  => $tenantConfig['username'],
            'password'  => $tenantConfig['password'],
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ]);

        // Reset and reconnect
        DB::purge('tenant');
        DB::reconnect('tenant');

        // Set up tenant-specific logging
        self::setTenantLogger($tenantConfig['database']);
    }

    /**
     * Configure tenant-specific logging.
     */
    public static function setTenantLogger($databaseName)
    {
        $logPath = storage_path("logs/tenants/{$databaseName}.log");

        Config::set('logging.channels.tenant', [
            'driver' => 'single',
            'path' => $logPath,
            'level' => env('LOG_LEVEL', 'debug'),
        ]);

        Log::info("Switched to tenant: {$databaseName}");
    }



}
