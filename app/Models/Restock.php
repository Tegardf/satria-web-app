<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restock extends Model
{
    protected $fillable = [
        'id_perhiasan',
        'id_produk',
        'model',
        'berat',
        'ukuran',
        'kadar',
        'jumlah',
        'status',
    ];

    public function perhiasan() {
        return $this->belongsTo(Perhiasan::class, 'id_perhiasan');
    }

    public function produk() {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
