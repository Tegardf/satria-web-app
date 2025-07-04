<?php

namespace Database\Seeders;

use App\Models\Pengeluaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            ['nama' => 'Beli Emas', 'nilai' => 1500000],
            ['nama' => 'Transport', 'nilai' => 50000],
            ['nama' => 'Makan Siang', 'nilai' => 25000],
            ['nama' => 'Perawatan Toko', 'nilai' => 100000],
        ];

        foreach ($data as $item) {
            Pengeluaran::create($item);
        }
    }
}
