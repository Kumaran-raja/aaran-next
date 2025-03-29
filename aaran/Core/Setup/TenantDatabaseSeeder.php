<?php

namespace  Aaran\Core\Setup;

use Aaran\Common\Database\Seeders\CitySeeder;
use Aaran\Common\Database\Seeders\DistrictSeeder;
use Illuminate\Database\Seeder;

class TenantDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CitySeeder::class,
            DistrictSeeder::class,
        ]);
    }
}
