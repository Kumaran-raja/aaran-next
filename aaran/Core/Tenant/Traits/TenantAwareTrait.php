<?php

namespace Aaran\Core\Tenant\Traits;

use Aaran\Core\Tenant\Helpers\TenantHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

trait TenantAwareTrait
{
    private function getTenantConnection(): string
    {
        if (config('database.default') === 'tenant' && Session::has('tenant_db_config')) {
            return 'tenant';
        }

        $tenantId = session('tenant_id');

        if ($tenantId && TenantHelper::switchTenant($tenantId)) {
            return 'tenant';
        }

        Log::error("Failed to switch to tenant. Session tenant_id: " . ($tenantId ?? 'null'));
        return config('database.default');
    }
}

