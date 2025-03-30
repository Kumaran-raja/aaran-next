<?php

namespace Aaran\Core\Tenant\Http\Middleware;

use Aaran\Core\Tenant\Helpers\TenantHelper;
use Aaran\Core\Tenant\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TenantDatabaseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('tenant_db_config')) {

            $tenantConfig = Session::get('tenant_db_config');

            TenantHelper::applyTenantConfig($tenantConfig);

            // Log every tenant request
            Log::channel('tenant')->info("Tenant Request: {$request->method()} - {$request->url()}");
        } else {

            // Fetch the authenticated user's tenant_id

            $user = Auth::user();

            if ($user && $user->tenant_id) {

                TenantHelper::switchTenant($user->tenant_id);

                Log::channel('tenant')->info("Calling Switch Tenant");
            }
        }

        return $next($request);
    }
}
