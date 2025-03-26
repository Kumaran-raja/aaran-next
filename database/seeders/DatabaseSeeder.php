<?php

namespace Database\Seeders;

use Aaran\Common\Database\Seeders\CitySeeder;
use Aaran\Core\Tenant\Database\Seeders\TenantSeeder;
use Aaran\Core\User\Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TenantSeeder::class,
            UserSeeder::class,

            CitySeeder::class,
        ]);
    }
}
