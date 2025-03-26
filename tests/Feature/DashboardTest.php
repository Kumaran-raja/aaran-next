<?php

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\User\Models\User;
use Aaran\Core\Tenant\Services\TenantDatabaseService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;


test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});


test('authenticated users can visit the dashboard', function () {
    // Create a tenant with a valid configuration
    $tenant = Tenant::factory()->create([
        't_name' => 'test-tenant',
    ]);

    // Create a user associated with the tenant
    $user = User::factory()->create([
        'name' => 'test-tenant-user', // Ensure this aligns with your authentication logic
    ]);

    // Simulate the middleware setting the tenant context
    Cache::put("tenant_{$user->username}", $tenant->toArray(), now()->addMinutes(30));
    Session::put('tenant', $tenant->toArray());

    // Mock the TenantDatabaseService to allow any tenant object
    $this->mock(TenantDatabaseService::class, function ($mock) {
        $mock->shouldReceive('setTenantConnection')->once()->with(Mockery::any());
    });

    // Authenticate as the user
    $this->actingAs($user);

    // Access the dashboard and assert success
    $this->get('/dashboard')->assertStatus(200);
});


