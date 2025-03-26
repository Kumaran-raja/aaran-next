<?php

namespace Aaran\Core\RBAC\Database\Seeders;

use Aaran\Core\RBAC\Models\Permission;
use Aaran\Core\RBAC\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define permissions for each role
        $rolePermissions = [
            'super-admin' => ['manage-users', 'manage-roles', 'manage-permissions', 'view-dashboard', 'manage-settings'],
            'admin' => ['manage-users', 'view-dashboard', 'manage-settings'],
            'auditor' => ['view-dashboard', 'audit-reports'],
            'user' => ['view-dashboard'],
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                $permissionIds = Permission::whereIn('name', $permissions)->pluck('id')->toArray();
                $role->permissions()->sync($permissionIds); // Assign permissions
            }
        }
    }
}


