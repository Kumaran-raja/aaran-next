<?php

namespace Aaran\Common\Models;

use Aaran\Common\Database\Factories\CityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class City extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['vname', 'active_id'];

    protected $casts = [
        'active_id' => 'boolean',
    ];

    public function scopeActive(Builder $query, $status = '1'): Builder
    {
        return $query->where('active_id', $status);
    }

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->where('vname', 'like', "%$search%");
    }

    protected static function newFactory(): CityFactory
    {
        return new CityFactory();
    }
}
