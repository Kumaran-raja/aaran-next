<?php

namespace Database\Seeders;

use Aaran\Core\Tenant\Database\Seeders\_TenantModuleSeeder;
use Aaran\Core\User\Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            _TenantModuleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
