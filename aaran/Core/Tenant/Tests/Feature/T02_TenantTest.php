<?php

namespace Aaran\Core\Tenant\Tests\Feature;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T02_TenantTest extends TestCase
{
    use RefreshDatabase;  // Ensures a fresh DB for each test

    /**
     * Test that a tenant can be created successfully.
     */
    public function test_can_create_tenant()
    {
        $tenant = Tenant::create([
            'name' => 'Test Tenant',
            'domain' => 'test.local',
            'config' => json_encode(['db' => 'test_db']),
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('tenants', ['domain' => 'test.local']);
    }

    /**
     * Test that a tenant can be retrieved by its domain.
     */
    public function test_can_retrieve_tenant_by_domain()
    {
        Tenant::create([
            'name' => 'Test Tenant',
            'domain' => 'test.local',
            'config' => json_encode(['db' => 'test_db']),
            'is_active' => true,
        ]);

        $tenant = Tenant::where('domain', 'test.local')->first();
        $this->assertNotNull($tenant);
    }

    /**
     * Test that a tenant's domain can be updated.
     */
    public function test_can_update_tenant()
    {
        $tenant = Tenant::factory()->create(['domain' => 'old.local']);

        $tenant->update(['domain' => 'new.local']);

        $this->assertDatabaseHas('tenants', ['domain' => 'new.local']);
    }

    /**
     * Test that a tenant can be deleted.
     */
    public function test_can_delete_tenant()
    {
        $tenant = Tenant::factory()->create();

        $tenant->delete();

        $this->assertDatabaseMissing('tenants', ['id' => $tenant->id]);
    }
}
