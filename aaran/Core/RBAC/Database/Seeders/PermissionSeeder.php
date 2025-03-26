<?php

namespace Aaran\Core\RBAC\Database\Seeders;

use Aaran\Core\RBAC\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = ['view-dashboard', 'manage-users', 'manage-roles', 'manage-settings'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}

