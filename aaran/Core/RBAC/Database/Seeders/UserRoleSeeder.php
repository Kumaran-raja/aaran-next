<?php

namespace Aaran\Core\RBAC\Database\Seeders;

use Aaran\Core\RBAC\Models\Role;
use Aaran\Core\User\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $userRoles = [
            'sundar@sundar.com' => ['super-admin', 'admin', 'auditor'], // Multiple roles for Super Admin
            'developer@aaran.org' => ['admin'],
            'audit@aaran.org' => ['auditor'],
            'demo@demo.com' => ['user'],
        ];

        foreach ($userRoles as $email => $roleNames) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
                $user->roles()->sync($roleIds); // Sync multiple roles
            }
        }
    }
}

