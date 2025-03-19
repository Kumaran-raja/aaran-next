<?php

namespace Aaran\Core\User\Http\Controllers;

use Aaran\Core\User\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle user login with dynamic authentication methods.
     */
    public function login(Request $request)
    {
        try {
            Log::info('Login Attempt', ['data' => $request->except('password')]);

            // Validate request credentials
            $credentials = $this->validateLoginRequest($request);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {

                $user = Auth::user();

                $request->session()->regenerate();

                if ($user->hasMfaEnabled()) {
                    return response()->json([
                        'message' => 'MFA required',
                        'mfa_required' => true
                    ], 200);
                }

                return response()->json(['message' => 'Login successful'], 200);
            }

            throw ValidationException::withMessages(['error' => 'Invalid credentials']);

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    /**
     * Validate login request dynamically based on enabled authentication methods.
     */
    protected function validateLoginRequest(Request $request)
    {
        $loginMethods = config('auth.login_methods', []);

        $rules = ['password' => 'required'];

        if (!empty($loginMethods)) {
            if (!empty($loginMethods['email'])) {
                $rules['email'] = 'required|email';
            } elseif (!empty($loginMethods['username'])) {
                $rules['username'] = 'required';
            } elseif (!empty($loginMethods['unique_id'])) {
                $rules['unique_id'] = 'required';
            } elseif (!empty($loginMethods['mobile'])) {
                $rules['mobile'] = 'required|numeric';
            }
        } else {
            throw ValidationException::withMessages(['error' => 'No login method is enabled.']);
        }

        return $request->validate($rules);
    }

    /**
     * Logout the user and invalidate session.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
