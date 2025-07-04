<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'bulan',
        
    ];

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'id_bulan');
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'id_bulan');
    }

}
