<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public static function run(): void
    {
        Tenant::create([
            'name' => 'codexsun',
            'domain' => 'demo.codexsun.com',
            'is_active' => '1',
        ]);
    }
}
