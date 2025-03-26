<?php

namespace Aaran\Core\Tenant\Database\Factories;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            't_name' => $this->faker->unique()->slug,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'db_name' => $this->faker->unique()->slug,
            'db_host' => '127.0.0.1',
            'db_port' => '3306',
            'db_user' => 'tenant_user',
            'db_pass' => bcrypt('password'),
            'plan' => 'free',
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
            'storage_limit' => 10,
            'user_limit' => 5,
            'is_active' => true,
            'settings' => json_encode([]),
            'features' => json_encode([]),
            'two_factor_enabled' => false,
            'api_key' => $this->faker->uuid,
            'whitelisted_ips' => null,
            'allow_sso' => false,
            'active_users' => 0,
            'requests_count' => 0,
            'disk_usage' => 0,
            'last_active_at' => now(),
        ];
    }
}

