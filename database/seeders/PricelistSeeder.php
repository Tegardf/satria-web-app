<?php

namespace Database\Seeders;

use App\Models\Perhiasan;
use App\Models\Pricelists;
use Illuminate\Database\Seeder;


class PricelistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kadarList = [
            ['kadar' => 24, 'harga_min' => 1100000, 'harga_max' => 1200000],
            ['kadar' => 23, 'harga_min' => 1050000, 'harga_max' => 1150000],
            ['kadar' => 22, 'harga_min' => 1000000, 'harga_max' => 1100000],
            ['kadar' => 21, 'harga_min' => 950000,  'harga_max' => 1050000],
            ['kadar' => 20, 'harga_min' => 900000,  'harga_max' => 1000000],
            ['kadar' => 18, 'harga_min' => 850000,  'harga_max' => 950000],
            ['kadar' => 16, 'harga_min' => 800000,  'harga_max' => 900000],
            ['kadar' => 14, 'harga_min' => 750000,  'harga_max' => 850000],
        ];
        foreach ($kadarList as $item) {
            Pricelists::create([
                'kadar' => $item['kadar'],
                'harga_min' => $item['harga_min'],
                'harga_max' => $item['harga_max'],
            ]);
        }
    }
}
