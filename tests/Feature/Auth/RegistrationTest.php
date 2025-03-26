<?php

use Aaran\Core\Auth\Livewire\Class\Register;
use Livewire\Livewire;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    // Create a default tenant
    $tenant = \Aaran\Core\Tenant\Models\Tenant::factory()->create();

    $response = Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register');

    // Assign the created tenant to the newly registered user
    $user = \Aaran\Core\User\Models\User::where('email', 'test@example.com')->first();
    $user->update(['tenant_id' => $tenant->id]);

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
