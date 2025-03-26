<?php

namespace Aaran\Core\Tenant\Http\Middleware;

use Aaran\Core\Tenant\Models\Tenant;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Aaran\Core\Tenant\Services\TenantDatabaseService;

class TenantMiddleware
{
    protected TenantDatabaseService $tenantDatabaseService;

    public function __construct(TenantDatabaseService $tenantDatabaseService)
    {
        $this->tenantDatabaseService = $tenantDatabaseService;
    }

    public function handle($request, Closure $next)
    {
        // Check if the request is routed through the 'web' middleware group
        if ($request->route() && collect($request->route()->gatherMiddleware())->contains('website')) {

            Log::info('Access Granted: Request passed through the web middleware group.', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
            ]);

            return $next($request);
        }

        Log::info('Tenant middleware triggered');

        if (Auth::check()) {
            $tenant = $this->getAuthenticatedTenant();

            if ($tenant) {
                $this->tenantDatabaseService->setTenantConnection($tenant);
            }
        } else {
            Log::warning("Unauthenticated request encountered in Tenant middleware");

            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        $response = $next($request);

        $this->disconnectTenantDatabase();

        return $response;
    }

    /**
     * Retrieves the authenticated tenant from cache, session, or database.
     */
    private function getAuthenticatedTenant(): ?Tenant
    {
        // Ensure the user is authenticated before accessing properties
        $user = Auth::user();

        if (!$user) {
            Log::warning("Unauthenticated request in getAuthenticatedTenant()");
            return null;
        }

        Log::info("Authenticated user: {$user->name} - {$user->email}");

        // Retrieve tenant from cache or session
        $tenantData = $this->getTenantFromCacheOrSession($user->email);

        if (!$tenantData) {

            Log::info("Tenant not found in cache/session, querying database...");

            if ($user) {
                $tenant = $this->fetchTenantFromDatabase($user->tenant_id);

            } else {
                Log::warning("No username provided; skipping database fetch.");
                return null;
            }

            if ($tenant) {
                $this->storeTenantInCacheAndSession($user->email, $tenant);
            } else {
                Log::warning("Tenant not found for user: {$user->email}");
                return null;
            }
        } else {

            Log::info("Tenant found in cache/session", ['tenant_id' => $tenantData['id']]);

            // Ensure we create a proper Tenant model instance
            $tenant = new Tenant();
            $tenant->forceFill($tenantData); // This fills model attributes correctly
            $tenant->exists = true; // Mark model as existing to avoid insert
        }

        return $tenant;
    }

    /**
     * Retrieves tenant data from cache or session.
     */
    private function getTenantFromCacheOrSession(?string $name): ?array
    {
        return Cache::get("tenant_{$name}") ?? Session::get('tenant');
    }

    /**
     * Fetches the tenant from the database.
     */
    private function fetchTenantFromDatabase(?string $v): ?Tenant
    {
        return Tenant::where('id', $v)
            ->select('id', 't_name', 'db_name','db_host', 'db_port', 'db_user', 'db_pass','is_active', 'settings', 'features' )
            ->first();
    }

    /**
     * Stores tenant data in cache and session for future requests.
     */
    private function storeTenantInCacheAndSession(string $v, Tenant $tenant): void
    {
        $tenantArray = $tenant->toArray();

        Cache::put("tenant_{$v}", $tenantArray, now()->addMinutes(30));

        Session::put('tenant', $tenantArray);

        Log::info("Tenant fetched and stored", ['tenant_id' => $tenant->id]);

    }

    /**
     * Safely disconnects the tenant database connection.
     */
    private function disconnectTenantDatabase(): void
    {
        if (!$this->shouldSkipDisconnection()) {
            Log::info("Disconnecting tenant database connection");
            DB::disconnect('tenant');
        }
    }

    /**
     * Determines if the tenant database connection should be skipped.
     */
    private function shouldSkipDisconnection(): bool
    {
        return app()->runningInConsole() && !app()->runningUnitTests() && config('queue.default') === 'database';
    }
}
