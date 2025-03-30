<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;

class _TenantModuleSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FeatureSeeder::class,
            IndustrySeeder::class,
            IndustryFeatureSeeder::class,
            TenantSeeder::class,
            TenantSettingsSeeder::class,
        ]);
    }
}
