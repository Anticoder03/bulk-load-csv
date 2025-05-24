<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Contact extends Model
{
    protected $fillable = [
    'name', 'email', 'phone', 'address', 'city', 'state', 'zip_code'
];

    
}
