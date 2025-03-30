<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // Create Tenants with Assigned Features
        $this->createTenant('tenant_1', 'tenant_1@gmail.com', 'sundar', 'DEVELOPER');
        $this->createTenant('tenant_2', 'tenant_2@gmail.com', 'codexsun', 'OFFSET');
    }

    /**
     * Create a tenant and assign features based on industry.
     */
    private function createTenant(string $name, string $email, string $contact, string $industryCode): void
    {
        // Fetch Industry ID
        $industry = DB::table('industries')->where('code', $industryCode)->first();
        if (!$industry) {
            return;
        }

        // Fetch Industry Features
        $industryFeatureCodes = DB::table('industry_features')
            ->join('features', 'industry_features.feature_id', '=', 'features.id')
            ->where('industry_features.industry_id', $industry->id)
            ->where('industry_features.is_active', true)
            ->pluck('features.code')
            ->toArray();

        // Convert to JSON
        $enabledFeatures = json_encode($industryFeatureCodes);

        // Create Tenant
        Tenant::create([
            'b_name' => $name,
            't_name' => $name,
            'email' => $email,
            'contact' => $contact,
            'phone' => '+91 1234567890',
            'db_name' => $name,
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
            'industry_code' => $industryCode,
            'settings' => json_encode([]),
            'enabled_features' => $enabledFeatures, // Store industry-based features
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
