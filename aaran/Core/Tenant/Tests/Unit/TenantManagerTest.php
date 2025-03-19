<?php

namespace Aaran\Core\Tenant\Tests\Unit;

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\Tenant\Services\TenantManager;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantManagerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure can find tenant by domain.
     */
    public function test_can_find_tenant_by_domain()
    {
        $tenant = Tenant::factory()->create(['domain' => 'test.local']);

        $tenantManager = new TenantManager();

        $foundTenant = $tenantManager->findByDomain('test.local');

        $this->assertEquals($tenant->id, $foundTenant->id);
    }

    /**
     * Ensure can create tenant.
     */
    public function test_can_create_tenant()
    {
        $tenantManager = new TenantManager();

        $tenant = $tenantManager->create([
            'name' => 'New Tenant',
            'domain' => 'new.local',
            'config' => ['db' => 'new_db'],
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('tenants', ['domain' => 'new.local']);
    }
}

