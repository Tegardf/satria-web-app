<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'id_bulan',
        'id_stock',
        'tanggal',
        'keterangan',
        'sales',
        'jumlah_keluar',
        'harga_jual',
    ];

    public function history() {
        return $this->belongsTo(History::class, 'id_bulan');
    }

    public function stock() {
        return $this->belongsTo(Stock::class, 'id_stock');
    }
}
