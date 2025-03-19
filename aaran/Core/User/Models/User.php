<?php

namespace Aaran\Core\User\Models;

use Aaran\Core\User\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'mfa_enabled', 'mfa_method', 'mfa_secret'
    ];

    protected $hidden = [
        'password', 'remember_token', 'mfa_secret'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user has MFA enabled.
     */
    public function hasMfaEnabled()
    {
        return $this->mfa_enabled;
    }

    /**
     * Check if the user is using an authenticator app.
     */
    public function hasAuthenticatorApp(): bool
    {
        return $this->mfa_method === 'authenticator_app';
    }


    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
