<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan_lain extends Model
{
    protected $fillable = [
        'jenis_penjualan',
        'berat',
        'harga',
        'keterangan',
    ];

}
