<?php

namespace Aaran\Core\User\Database\Seeders;

use Aaran\Core\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'SUNDAR', 'email' => 'sundar@sundar.com', 'password' => 'kalarani'],
            ['name' => 'Developer', 'email' => 'developer@aaran.org', 'password' => '123456789'],
            ['name' => 'audit', 'email' => 'audit@aaran.org', 'password' => '123456789'],
            ['name' => 'demo', 'email' => 'demo@demo.com', 'password' => '123456789'],
        ];

        foreach ($users as $row) {
            $user = User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => bcrypt($row['password']),
                'email_verified_at' => now(),
                'active_id' => '1',
                'tenant_id' => '1',
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
