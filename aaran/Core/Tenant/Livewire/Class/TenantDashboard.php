<?php

namespace Aaran\Core\Tenant\Livewire\Class;

use Aaran\Core\Tenant\Services\TenantManager;
use Livewire\Component;

class TenantDashboard extends Component
{
    public function render()
    {
        $tenant = TenantManager::getTenant();
        return view('tenant::tenant.dashboard', compact('tenant'));
    }
}

