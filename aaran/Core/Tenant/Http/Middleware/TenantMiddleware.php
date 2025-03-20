<?php

namespace Aaran\Core\Tenant\Http\Middleware;

use Aaran\Core\Tenant\Models\Tenant;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        // Identify tenant by domain
        $domain = $request->getHost();

        $tenant = Cache::rememberForever('tenant_' . $domain, function () use ($domain) {
            return Tenant::where('domain', $domain)->first();
        });



        // Ensure tenant exists and is active
        if (!$tenant || !$tenant->is_active) {
            abort(404, "Tenant not found or inactive");
        }

        // Ensure getConfig method exists before calling
        if (!method_exists($tenant, 'getConfig')) {
            throw new \Exception("Method getConfig() not found in Tenant model");
        }

        // Set database connection dynamically
        Config::set('database.connections.tenant', [
            'driver' => 'mysql',
            'host' => env('TENANT_DB_HOST', '127.0.0.1'),
            'database' => $tenant->getConfig('database.name', 'default_db'),
            'username' => $tenant->getConfig('database.username', 'root'),
            'password' => $tenant->getConfig('database.password', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);

//         dd($tenant);

        // Purge & reconnect to the new database
        DB::purge('tenant');
        DB::reconnect('tenant');

        return $next($request);
    }
}
