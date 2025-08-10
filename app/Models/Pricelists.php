<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricelists extends Model
{
    protected $fillable = [
        'id_perhiasan',
        'kadar', 
        'harga_min', 
        'harga_max'
    ];

    public function perhiasan()
    {
        return $this->belongsTo(Perhiasan::class, 'id_perhiasan');
    }
}
