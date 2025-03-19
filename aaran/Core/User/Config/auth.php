<?php


return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Features
    |--------------------------------------------------------------------------
    | Configure which authentication methods are allowed in Aaran-Next.
    | Toggle these options to enable or disable login methods dynamically.
    */

    'login_methods' => [
        'email' => true,  // Enable Email + Password login
        'username' => true, // Allow Username + Password login
        'unique_id' => false, // Login via Unique User ID
        'mobile' => false, // Mobile Number + Password
        'oauth' => false,  // Enable OAuth (Google, Facebook, etc.)
    ],

    /*
    |--------------------------------------------------------------------------
    | Multi-Factor Authentication (MFA)
    |--------------------------------------------------------------------------
    | Define which MFA methods are available for users.
    */

    'mfa' => [
        'enabled' => true, // Enable or disable MFA globally
        'email' => true, // Send OTP via email
        'sms' => false, // Send OTP via SMS
        'authenticator_app' => true, // Google Authenticator, Authy
    ],

    /*
    |--------------------------------------------------------------------------
    | Session & Security
    |--------------------------------------------------------------------------
    | Control session-related security settings.
    */

    'session' => [
        'remember_me' => true, // Enable "Remember Me"
        'expire_time' => 120, // Session expiration in minutes
        'device_tracking' => true, // Track login devices
        'ip_restriction' => false, // Restrict login from unknown IPs
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Recovery & Reset
    |--------------------------------------------------------------------------
    | Control password recovery options.
    */

    'password_reset' => [
        'enabled' => true,
        'method' => 'email', // Options: 'email', 'sms', 'both'
        'token_expiration' => 60, // Token expiration in minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | API Authentication
    |--------------------------------------------------------------------------
    | Control API authentication settings.
    */

    'api' => [
        'sanctum' => true, // Enable Laravel Sanctum
        'oauth' => true, // Allow OAuth logins for API users
    ],
];
