<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gesek extends Model
{
    protected $fillable = [
        'id_perhiasan',
        'nama_bank',
        'nama',
        'masuk',
        'keluar',
    ];

    public function perhiasan() {
        return $this->belongsTo(Perhiasan::class, 'id_perhiasan');
    }
}
