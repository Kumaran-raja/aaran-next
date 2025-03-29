<?php

namespace Aaran\Dashboard\Livewire\Class;

use Aaran\Core\Tenant\Facades\TenantManager;
use Livewire\Component;

class Index extends Component
{

    public string $tenant;
    public string $tenantSettings;
    public string $tenantDefaultCompany;

    public function render()
    {
        $this->tenant = TenantManager::getTenant();
//        $this->tenantSettings = TenantManager::getSettings();
//        $this->tenantDefaultCompany = TenantManager::getCompany();



        return view('dashboard::index');
    }

}
