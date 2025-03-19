<?php

namespace Aaran\Core\Tenant\Tests\Feature;

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class T04_MultiTenantAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure a user cannot log in to the wrong tenant.
     */
    public function test_user_cannot_login_to_wrong_tenant()
    {
        // Ensure Tenant Factory exists
        $tenant1 = Tenant::factory()->create(['domain' => 'tenant1.local']);
        $tenant2 = Tenant::factory()->create(['domain' => 'tenant2.local']);

        // Ensure User Factory exists
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'tenant_id' => $tenant1->id,
            'password' => Hash::make('password'), // Use Hash::make
        ]);

        // Attempt login on wrong tenant
        $response = $this->withHeader('Host', 'tenant2.local')
            ->post('/login', [
                'email' => 'user@example.com',
                'password' => 'password',
            ]);

        // Dump response for debugging
//        $response->dump(); // <-- Add this to see actual response

        $response->assertSessionHasErrors(['email']); // Ensure login fails
        $this->assertGuest(); // User should not be authenticated
    }


    /**
     * Ensure a user can log in to the correct tenant.
     */
    public function test_user_can_login_to_correct_tenant()
    {
        $tenant = Tenant::factory()->create(['domain' => 'tenant1.local']);

        $user = User::factory()->create([
            'email' => 'user@example.com',
            'tenant_id' => $tenant->id,
            'password' => Hash::make('password'),
        ]);

        // Attempt login on correct tenant
        $response = $this->withHeader('Host', 'tenant1.local')
            ->post('/login', [
                'email' => 'user@example.com',
                'password' => 'password',
            ]);

        $response->assertRedirect('/dashboard'); // Ensure successful login redirects
        $this->assertAuthenticated(); // Check if user is logged in
    }
}
