<?php

namespace Aaran\Auth\Identity\Http\Controllers;

use Aaran\Auth\Identity\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Show all users in a Blade view
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('identity::index', compact('users'));
    }

    // Show user creation form
    public function create()
    {
        return view('identity::create');
    }

    // Store new user from web form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $this->userService->registerUser($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Show user edit form
    public function edit($id)
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        return view('identity::edit', compact('user'));
    }

    // Update user details
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $this->userService->updateUser($id, $validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
