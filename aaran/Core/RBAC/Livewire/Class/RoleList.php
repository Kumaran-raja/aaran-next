<?php

namespace Aaran\Core\RBAC\Livewire\Class;

use Aaran\Core\Tenant\Services\TenantManager;
use Livewire\Component;

class RoleList extends Component
{
    public function render()
    {
        return view('rbac::role-list');
    }
}

