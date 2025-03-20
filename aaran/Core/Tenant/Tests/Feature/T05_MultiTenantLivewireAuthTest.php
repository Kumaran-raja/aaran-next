<?php

namespace Aaran\Core\Tenant\Tests\Feature;

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\User\Models\User;
use App\Livewire\Auth\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class T05_MultiTenantLivewireAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure a user cannot log in to the wrong tenant.
     */
    public function test_user_cannot_login_to_wrong_tenant()
    {
        $tenant1 = Tenant::factory()->create(['domain' => 'tenant1.local']);
        $tenant2 = Tenant::factory()->create(['domain' => 'tenant2.local']);

        $user = User::factory()->create([
            'email' => 'user@example.com',
            'tenant_id' => $tenant1->id,
            'password' => Hash::make('password'),
        ]);

        Livewire::test(Login::class)
            ->set('email', 'user@example.com')
            ->set('password', 'password')
            ->call('login')
            ->assertHasErrors(['email']) // Check for validation error
            ->assertSee(__('auth.failed')); // Ensure correct error message is displayed
    }

}
