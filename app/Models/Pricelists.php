<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricelists extends Model
{
    protected $fillable = [
        'kadar', 
        'harga_min', 
        'harga_max'
    ];
}
