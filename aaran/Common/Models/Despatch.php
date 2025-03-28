<?php

namespace Aaran\Common\Models;

use Aaran\Common\Database\Factories\DespatchFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despatch extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    public static function search(string $searches)
    {
        return empty($searches) ? static::query()
            : static::where('vname', 'like', '%' . $searches . '%');
    }

    protected static function newFactory(): DespatchFactory
    {
        return new DespatchFactory();
    }

}
