<?php

namespace Aaran\Core\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

class TenantSetting extends Model
{
    protected $table = 'tenant_settings'; // Ensure the table name matches

    protected $fillable = ['tenant_id', 'key', 'value'];
}
