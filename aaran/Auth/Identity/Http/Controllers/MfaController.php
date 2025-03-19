<?php

namespace Aaran\Auth\Identity\Http\Controllers;

use Aaran\Auth\Identity\Models\User;
use Aaran\Auth\Identity\Notifications\MfaOtpNotification;
use Aaran\Core\Tenant\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MfaController extends Controller
{
    /**
     * Trigger MFA process after login if enabled.
     */
    public function sendMfa(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->hasMfaEnabled()) {
            return response()->json(['error' => 'MFA is not enabled for this user'], 400);
        }

        Log::info("MFA triggered for user ID: {$user->id}");

        if ($user->hasAuthenticatorApp()) {
            return response()->json(['message' => 'Enter your authenticator app code'], 200);
        }

        $user->notify(new MfaOtpNotification());
        return response()->json(['message' => 'OTP sent via email'], 200);
    }

    /**
     * Verify MFA code submitted by the user.
     */
    public function verifyMfa(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $user = Auth::user();
        $cachedOtp = Cache::get("mfa_otp_{$user->id}");

        if ($request->otp == $cachedOtp) {
            Cache::forget("mfa_otp_{$user->id}");
            return response()->json(['message' => 'MFA verification successful'], 200);
        }

        return response()->json(['error' => 'Invalid OTP'], 401);
    }

    /**
     * Enable Multi-Factor Authentication (MFA) for the user.
     */
    public function enableMfa(Request $request)
    {
        $request->validate(['method' => 'required|in:email,authenticator_app']);

        $user = Auth::user();
        $user->update([
            'mfa_enabled' => true,
            'mfa_method' => $request->method
        ]);

        return response()->json(['message' => 'MFA enabled successfully'], 200);
    }
}
