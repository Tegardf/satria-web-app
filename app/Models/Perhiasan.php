<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perhiasan extends Model
{
    protected $fillable = ['jenis'];

    public function stocks() {
        return $this->hasMany(Stock::class, 'id_perhiasan');
    }
    
    public function restocks()
    {
        return $this->hasMany(Restock::class, 'id_perhiasan');
    }

    public function geseks()
    {
        return $this->hasMany(Gesek::class, 'id_perhiasan');
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'id_perhiasan');
    }
}
