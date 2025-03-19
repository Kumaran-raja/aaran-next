<?php

namespace Aaran\Core\Tenant\Http\Middleware;

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\Tenant\Services\TenantManager;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        // Identify tenant by domain
        $domain = $request->getHost();

        $tenant = Cache::rememberForever('tenant_' . $domain, function () use ($domain) {
            return Tenant::where('domain', $domain)->first();
        });

        if (!$tenant || !$tenant->is_active) {
            abort(404, "Tenant not found or inactive");
        }

        // Set database connection dynamically
        config(['database.connections.tenant' => [
            'driver' => 'mysql',
            'host'     => env('TENANT_DB_HOST', '127.0.0.1'),
            'database' => $tenant->getConfig('database.name', 'default_db'),
            'username' => $tenant->getConfig('database.username', 'root'),
            'password' => $tenant->getConfig('database.password', ''),
        ]]);

        // Switch database
        DB::purge('tenant');
        DB::reconnect('tenant');

        return $next($request);
    }
}
