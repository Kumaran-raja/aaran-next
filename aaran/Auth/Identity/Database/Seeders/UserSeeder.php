<?php

namespace Aaran\Auth\Identity\Database\Seeders;

use Illuminate\Database\Seeder;
use Aaran\Auth\Identity\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(10)->create();
    }
}
