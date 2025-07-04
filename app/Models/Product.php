<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['jenis'];

    public function stocks() {
        return $this->hasMany(Stock::class, 'id_produk');
    }
    
    public function restocks()
    {
        return $this->hasMany(Restock::class, 'id_produk');
    }
    
    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'id_perhiasan');
    }
}
