<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::create([
            'name' => 'tenant_1',
            't_name' => 'tenant_1',
            'email' => 'tenant_1@gmail.com',
            'phone' => '+91 1234567890',
            'db_name' => 'tenant_1',
            'db_host' => '127.0.0.1',
            'db_port' => '3306',
            'db_user' => 'root',
            'db_pass' => 'Computer.1',
            'plan' => 'free',
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
            'storage_limit' => 10,
            'user_limit' => 5,
            'is_active' => true,
            'settings' => json_encode([]),
            'features' => json_encode([]),
            'two_factor_enabled' => false,
            'api_key' => '123456',
            'whitelisted_ips' => null,
            'allow_sso' => false,
            'active_users' => 0,
            'requests_count' => 0,
            'disk_usage' => 0,
            'last_active_at' => now(),
        ]);

        Tenant::create([
            'name' => 'tenant_2',
            't_name' => 'tenant_2',
            'email' => 'tenant_2@gmail.com',
            'phone' => '+91 1234567890',
            'db_name' => 'tenant_2',
            'db_host' => '127.0.0.1',
            'db_port' => '3306',
            'db_user' => 'root',
            'db_pass' => 'Computer.1',
            'plan' => 'free',
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
            'storage_limit' => 10,
            'user_limit' => 5,
            'is_active' => true,
            'settings' => json_encode([]),
            'features' => json_encode([]),
            'two_factor_enabled' => false,
            'api_key' => '123456',
            'whitelisted_ips' => null,
            'allow_sso' => false,
            'active_users' => 0,
            'requests_count' => 0,
            'disk_usage' => 0,
            'last_active_at' => now(),
        ]);
    }
}
