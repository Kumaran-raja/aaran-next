<?php

namespace Aaran\Core\Tenant\Services;

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\Tenant\Models\TenantSetting;
use Illuminate\Support\Facades\Auth;

class TenantManagerService
{
    protected $tenant;

    protected function resolveTenant()
    {
        if (Auth::check()) {
            return Tenant::where('id', Auth::user()->tenant_id)->first();
        }

        return null;
    }

    public function getId()
    {
        if (!$this->tenant) {
            $this->tenant = $this->resolveTenant();
        }

        return $this->tenant ? $this->tenant->id : null;
    }

    public function getTenant()
    {
        if (!$this->tenant) {
            $this->tenant = $this->resolveTenant();
        }

        return $this->tenant;
    }

    public function getSettings()
    {
        $tenant = $this->getTenant();
        if (!$tenant) {
            return json_encode([]);// Empty JSON object as string
        }

        $settings = TenantSetting::where('tenant_id', $tenant->id)
            ->pluck('value', 'key')
            ->toArray();

        return json_decode(json_encode($settings)); // Convert array to object
    }

    public function getCompany()
    {
        $tenant = $this->getTenant();
        return $tenant ? $tenant->defaultCompany : null;
    }

}
