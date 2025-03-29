<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\Tenant\Models\TenantSetting;
use Illuminate\Database\Seeder;

class TenantSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            TenantSetting::insert([
                [
                    'tenant_id' => $tenant->id,
                    'key' => 'default_company',
                    'value' => 'Codexsun',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'tenant_id' => $tenant->id,
                    'key' => 'acc_year',
                    'value' => '2024-2025',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'tenant_id' => $tenant->id,
                    'key' => 'currency',
                    'value' => 'USD',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'tenant_id' => $tenant->id,
                    'key' => 'timezone',
                    'value' => 'UTC',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}
