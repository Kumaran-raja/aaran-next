<?php


namespace Aaran\Auth\Identity\Livewire\Class;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Aaran\Auth\Identity\Services\UserService;

class LoginForm extends Component
{
    public $email, $password, $remember = false;
    protected UserService $userService;

    public function boot(UserService $userService): void
    {
        $this->userService = $userService;
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = ['email' => $this->email, 'password' => $this->password];

        if ($this->userService->authenticate($credentials, $this->remember)) {
            return redirect()->route('dashboard');
        }

        throw ValidationException::withMessages(['email' => 'Invalid credentials.']);
    }

    public function render()
    {
        return view('identity::login-form');
    }
}
