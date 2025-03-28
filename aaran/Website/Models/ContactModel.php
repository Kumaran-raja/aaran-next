<?php

namespace aaran\Website\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    use HasFactory;
    protected $table = 'contact_message';
    protected $fillable = ['name','email','phone','message'];
}
