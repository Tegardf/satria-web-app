<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'id_perhiasan',
        'id_produk',
        'kode',
        'nama',
        'tanggal',
        'jumlah',
        'berat_kotor',
        'berat_bersih',
        'berat_kitir',
        'pergram',
        'real',
    ];

    public function perhiasan() {
        return $this->belongsTo(Perhiasan::class, 'id_perhiasan');
    }

    public function produk() {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'id_stock');
    }

}
