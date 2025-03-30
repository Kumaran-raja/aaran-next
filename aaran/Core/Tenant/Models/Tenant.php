<?php

namespace Aaran\Core\Tenant\Models;

use Aaran\Core\Tenant\Database\Factories\TenantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tenants'; // Explicitly set table name

    protected $fillable = [
        'b_name', 't_name', 'email', 'contact', 'phone',
        'db_name', 'db_host', 'db_port', 'db_user', 'db_pass',
        'plan', 'subscription_start', 'subscription_end',
        'storage_limit', 'user_limit', 'is_active',
        'two_factor_enabled', 'allow_sso', 'config', 'active_id'
    ];

    protected $casts = [
        'config' => 'array', // Laravel handles JSON fields as arrays
        'subscription_start' => 'date',
        'subscription_end' => 'date',
        'is_active' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'allow_sso' => 'boolean',
    ];

    /**
     * Get a config value with a default fallback.
     */
    public function getConfig($key, $default = null)
    {
        return data_get($this->config ?? [], $key, $default);
    }

    /**
     * Relationship: A Tenant has many Users.
     */
    public function users()
    {
        return $this->hasMany(\Aaran\Core\User\Models\User::class);
    }

    /**
     * Define the factory for this model.
     */
    protected static function newFactory(): TenantFactory
    {
        return TenantFactory::new();
    }
}
