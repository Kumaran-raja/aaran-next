<?php

namespace Aaran\Core\Tenant\Services;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PDO;

class TenantDatabaseService
{
    /**
     * Set the database connection for a given tenant.
     */
    public function setTenantConnection(Tenant $tenant): void
    {
        $cacheKey = "tenant_config_{$tenant->id}";

        // Retrieve tenant database config from cache or generate it
        $config = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($tenant) {
            return $tenant;
        });

        // Log switching attempt
        Log::debug("2. Switching to a tenant database instance.");

        // Check if the 'tenant' connection is already configured
        if (!Config::has("database.connections.tenant")) {
            Log::info("Tenant database connection not found. Creating a new one...");

            DB::purge("tenant");
            $this->configureTenantDatabase($config);
            DB::reconnect('tenant');
        }

        // Purge and reconnect only if necessary
        $this->resetTenantConnectionIfNeeded($config);

        // Verify if Laravel recognizes the connection
        if (!array_key_exists('tenant', config('database.connections'))) {
            throw new \Exception("Failed to register tenant database connection.");
        }
    }

    /**
     * Get tenant database configuration from the Tenant model.
     */
    private function getTenantConfig(Tenant $tenant): array
    {
        $config = json_decode($tenant->config, true);

        // Validate JSON and required fields
        if ($errorMessage = $this->getJsonErrorMessage($config)) {
            Log::error("Invalid tenant JSON config: {$errorMessage}");
            throw new \RuntimeException("Invalid JSON configuration: {$errorMessage}");
        }

        foreach (['database', 'username', 'password', 'host', 'port'] as $field) {
            if (empty($config[$field])) {
                Log::error("Missing required tenant config field: {$field}");
                throw new \RuntimeException("Invalid tenant configuration.");
            }
        }

        return $config;
    }

    /**
     * Set up the database configuration for the tenant dynamically.
     */
    private function configureTenantDatabase(Tenant $tenant): void
    {
        Config::set("database.connections.tenant", [
            'driver' => 'mysql',
            'host' => $tenant->db_host ?? env('DB_HOST', '127.0.0.1'),
            'port' => $tenant->db_port ?? env('DB_PORT', '3306'),
            'database' => $tenant->db_name ?? env('DB_DATABASE', 'forge'),
            'username' => $tenant->db_user ?? env('DB_USERNAME', 'root'),
            'password' => $tenant->db_pass ?? env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ]);

        Log::debug("Tenant database connection configured.");
    }

    /**
     * Reset the tenant connection only if it's different from the current one.
     */
    private function resetTenantConnectionIfNeeded(Tenant $tenant): void
    {
        $tenantConnection = DB::connection('tenant');

        // Check if there's an active transaction before purging
        if ($tenantConnection->transactionLevel()) {
            Log::warning("Cannot purge 'tenant' connection while a transaction is active.");
            return;
        }

        // Compare the current connection database with the new one
        if ($tenantConnection->getDatabaseName() !== $tenant->db_name) {
            if ($this->isTenantConnectionInUse()) {
                Log::warning("Skipping 'tenant' connection purge as it is still in use.");
                return;
            }

            // Purge the previous connection and apply new settings
            DB::purge('tenant');
            $this->configureTenantDatabase($tenant);
            DB::reconnect('tenant');

            Log::info("Switched to tenant database: " . DB::connection('tenant')->getDatabaseName());
        }
    }

    /**
     * Check if the tenant database connection is currently in use.
     */
    private function isTenantConnectionInUse(): bool
    {
        try {
            return DB::connection('tenant')->getPdo() !== null;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get JSON decoding error message (if any).
     */
    private function getJsonErrorMessage($jsonData): ?string
    {
        if ($jsonData !== null || json_last_error() === JSON_ERROR_NONE) {
            return null;
        }

        return match (json_last_error()) {
            JSON_ERROR_DEPTH => "Maximum stack depth exceeded.",
            JSON_ERROR_STATE_MISMATCH => "Underflow or mismatched modes.",
            JSON_ERROR_CTRL_CHAR => "Unexpected control character found.",
            JSON_ERROR_SYNTAX => "Syntax error, malformed JSON.",
            JSON_ERROR_UTF8 => "Malformed UTF-8 characters.",
            default => "Unknown JSON error."
        };
    }

    /**
     * set tenant.
     */
    public function set(): void
    {
        // Retrieve tenant from session
        $tenantId = Session::get('tenant_id');

        if (!$tenantId) {
            throw new \Exception('No tenant found in session.');
        }

        $tenant = Tenant::find($tenantId);

        if (!$tenant || !$tenant->db_name) {
            throw new \Exception('Tenant database not found.');
        }

        try {
            $this->setTenantConnection($tenant);
        } catch (\Exception $e) {

        }

    }
}
