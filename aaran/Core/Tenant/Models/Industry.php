<?php

namespace Aaran\Core\Tenant\Models;

use Aaran\Core\Tenant\Database\Factories\TenantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'industries'; // Explicitly set table name

    protected $fillable = ['name', 'code','is_active'];

    protected $casts = [
        'is_active' => 'boolean',
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
