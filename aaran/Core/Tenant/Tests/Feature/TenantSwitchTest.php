<?php

namespace Aaran\Core\Tenant\Tests\Feature;

use Aaran\Core\Tenant\Helpers\TenantHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantSwitchTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_switching_success()
    {
        // Fake session data for a tenant
        session(['tenant_id' => 1, 'tenant_db_config' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'tenant_1',
            'username' => 'root',
            'password' => 'Computer.1',
        ]]);


        // Call switchTenant method
        $result = TenantHelper::switchTenant(session('tenant_id'));

        // Assert the switch was successful
        $this->assertTrue($result);

        // Assert database connection changed
        $this->assertEquals(config('database.connections.tenant.database'), 'tenant_db_1');
    }
}
