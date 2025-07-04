<?php

namespace Database\Seeders;

use App\Models\Penjualan_lain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenjualanLainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            [
                'jenis_penjualan' => 'Emas Sisa',
                'berat' => 150,
                'harga' => 1250000,
                'keterangan' => 'Penjualan emas sisa dari produksi'
            ],
            [
                'jenis_penjualan' => 'Perak',
                'berat' => 300,
                'harga' => 600000,
                'keterangan' => 'Penjualan perak bekas'
            ],
            [
                'jenis_penjualan' => 'Limbah Emas',
                'berat' => 75,
                'harga' => 350000,
                'keterangan' => 'Limbah emas dari proses pembersihan'
            ]
        ];

        foreach ($data as $item) {
            Penjualan_lain::create($item);
        }
    }
}
