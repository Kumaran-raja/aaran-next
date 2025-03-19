<?php


namespace Aaran\Core\User\Livewire\Class;

use Aaran\Core\User\Services\UserService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

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
