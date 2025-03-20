<?php

namespace Aaran\Core\Tenant\Tests\Feature;

use Aaran\Core\Tenant\Services\TenantService;
use Aaran\Core\User\Models\User;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantDatabaseSwitchTest extends TestCase
{
    use RefreshDatabase;

    private $tenant;
    private $user;
    private $retrievedTenant;

    /**
     * Set up test environment with a default tenant and user.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Step 1: Ensure tenants table exists
        $this->assertTrue(Schema::hasTable('tenants'), "The tenants table must exist.");

        // Step 2: Create a Tenant
        $this->tenant = Tenant::create([
            'name' => 'Test Tenant',
            'domain' => 'test.local',
            'config' => json_encode(['db' => 'test_db']),
            'is_active' => true,
        ]);

        // Step 3: Ensure the tenant is created
        $this->assertDatabaseHas('tenants', ['domain' => 'test.local']);

        // Step 4: Create User associated with the Tenant
        $this->user = User::factory()->create([
            'email' => 'tenantuser@example.com',
            'password' => Hash::make('password'),
            'tenant_id' => $this->tenant->id,
        ]);

        // Step 5: Retrieve Tenant from user
        $this->retrievedTenant = Tenant::find($this->user->tenant_id);
        $this->assertNotNull($this->retrievedTenant, "Tenant should be found for the user.");
    }

    /**
     * Test Step 1: Ensure database connection is active
     */
    public function test_Ensure_database_exists()
    {
        $this->assertNotNull(DB::connection(), "Database connection should be active.");
    }

    /**
     * Test Step 2: Retrieve the tenant database using the user's email
     */
    public function test_Retrieve_tenant_using_user_email()
    {
        $tenantDbName = json_decode($this->retrievedTenant->config, true)['db'];
        $this->assertEquals('test_db', $tenantDbName, "Database name should be retrieved correctly.");
    }

    /**
     * Test Step 3: Switch to the correct tenant database
     */
    public function test_Switch_to_correct_tenant()
    {
        $tenantService = app(TenantService::class);
        $tenantService->switchDatabase($this->retrievedTenant);

        $currentDb = DB::connection('tenant')->getDatabaseName();
        Log::info('Switched to Database: ' . $currentDb);

        $tenantDbName = json_decode($this->retrievedTenant->config, true)['db'];
        $this->assertEquals($tenantDbName, $currentDb, "Database should be switched correctly.");
    }

    /**
     * Test Step 4: Attempt login and verify authentication after DB switch
     */
    public function test_it_checks_tenant_database_switching_before_authentication()
    {
        $tenantService = app(TenantService::class);
        $tenantService->switchDatabase($this->retrievedTenant);

        $credentials = ['email' => 'tenantuser@example.com', 'password' => 'password'];
        $this->assertTrue(Auth::attempt($credentials), "User should be able to log in.");

        Log::info("Multi-Tenant Authentication Test Passed ✅");
    }
}
