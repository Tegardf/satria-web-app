<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = [
        'id_bulan',
        'id_perhiasan',
        'id_produk',
        'tanggal',
        'nama_barang',
        'kadar',
        'berat',
        'kode',
        'pergram_beli',
        'pergram_jual',
        'keterangan',
        'sales',
    ];

    public function history() {
        return $this->belongsTo(History::class, 'id_bulan');
    }

    public function perhiasan() {
        return $this->belongsTo(Perhiasan::class, 'id_perhiasan');
    }
    
    public function produk() {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
