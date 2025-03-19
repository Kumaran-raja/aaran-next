<?php

namespace Aaran\Core\User\Database\Seeders;

use Aaran\Core\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public static function run(): void
    {
        User::create([
            'name' => 'SUNDAR',
            'email' => 'sundar@sundar.com',
            'password' => bcrypt('kalarani'),
            'email_verified_at' => now(),
            'active_id' => '1',
            'tenant_id' => '1',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Developer',
            'email' => 'developer@aaran.org',
            'password' => bcrypt('123456789'),
            'email_verified_at' => now(),
            'active_id' => '1',
            'tenant_id' => '1',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'audit',
            'email' => 'audit@aaran.org',
            'password' => bcrypt('123456789'),
            'email_verified_at' => now(),
            'active_id' => '1',
            'tenant_id' => '1',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'demo',
            'email' => 'demo@demo.com',
            'password' => bcrypt('123456789'),
            'email_verified_at' => now(),
            'active_id' => '1',
            'tenant_id' => '1',
            'remember_token' => Str::random(10),
        ]);
    }
}
