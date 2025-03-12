<?php

namespace Aaran\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Aaran\Auth\Identity\Database\Seeders\UserSeeder;

class CoreSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
    }
}

