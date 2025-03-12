<?php

namespace Database\Seeders;

use Aaran\Core\Database\Seeders\CoreSeeder;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CoreSeeder::class);
    }
}
