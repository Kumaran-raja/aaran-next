<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public static function run(): void
    {
        Tenant::create([
            'name' => 'Local Tenant',
            'domain' => '127.0.0.1',
            'is_active' => true,
            'config' => json_encode([
                'database' => [
                    'name' => 'aaran_next',
                    'username' => 'root',
                    'password' => 'Computer.1',
                ]
            ])
        ]);
    }
}
