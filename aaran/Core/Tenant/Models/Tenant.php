<?php

namespace Aaran\Core\Tenant\Models;

use Aaran\Auth\Identity\Models\User;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['name', 'domain', 'database', 'status'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
