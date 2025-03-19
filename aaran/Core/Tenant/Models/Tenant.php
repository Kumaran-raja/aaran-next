<?php

namespace Aaran\Core\Tenant\Models;

use Aaran\Core\Tenant\Database\Factories\TenantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'domain', 'config', 'active_id'];

    protected $casts = [
        'config' => 'array', // Auto-converts JSON field to an array
    ];

    public function getConfig($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    public function users()
    {
        return $this->hasMany(\Aaran\Core\User\Models\User::class);
    }

    protected static function newFactory(): TenantFactory
    {
        return TenantFactory::new();
    }
}
