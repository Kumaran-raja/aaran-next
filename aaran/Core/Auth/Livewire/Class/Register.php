<?php

namespace Aaran\Core\Auth\Livewire\Class;

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\User\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // ✅ Assign the tenant_id
        $validated['tenant_id'] = $this->getTenantId();

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Get the current tenant ID or create a default one.
     */
    private function getTenantId(): int
    {
        return session('tenant_id') ?? Tenant::first()->id ?? Tenant::factory()->create()->id;
    }


    public function render()
    {
        return view('auth::register');
    }
}
