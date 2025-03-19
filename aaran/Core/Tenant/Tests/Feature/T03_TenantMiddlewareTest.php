<?php

namespace Aaran\Core\Tenant\Tests\Feature;

use Aaran\Core\Tenant\Models\Tenant;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class T03_TenantMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure accessing tenant with invalid domain.
     */
    public function test_accessing_tenant_with_invalid_domain_fails()
    {
        $response = $this->get('http://invalid.local');

        $response->assertStatus(404);
    }

    /**
     * Ensure accessing tenant with valid domain passes.
     */
    public function test_accessing_tenant_with_valid_domain_passes()
    {
        $tenant = Tenant::factory()->create(['domain' => 'valid.local']);

        $response = $this->get('http://valid.local');

        $response->assertStatus(200);
    }
}
