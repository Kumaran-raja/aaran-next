<?php

namespace Aaran\Core\Tenant\Services;

use Aaran\Core\Tenant\Models\TenantSetting;
use Aaran\Core\Tenant\Facades\TenantManager;
use Illuminate\Support\Facades\Session;

class TenantSettingsService
{
    public function loadSettings()
    {
        if (!Session::has('tenant_settings')) {

            $tenantId = TenantManager::getId();

            $settings = TenantSetting::where('tenant_id', $tenantId)
                ->pluck('value', 'key');

            Session::put('tenant_settings', $settings);
        }

        return Session::get('tenant_settings');
    }

    public function get($key, $default = null)
    {
        $settings = Session::get('tenant_settings', []);
        return $settings[$key] ?? $default;
    }
}
