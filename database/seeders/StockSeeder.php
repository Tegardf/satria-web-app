<?php

namespace Database\Seeders;

use App\Models\Perhiasan;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perhiasans = Perhiasan::all();
        $products = Product::all();

        // Optional: truncate before seeding
        // DB::table('stocks')->truncate();

        foreach ($perhiasans as $perhiasan) {
            foreach ($products as $product) {
                Stock::create([
                    'id_perhiasan' => $perhiasan->id,
                    'id_produk' => $product->id,
                    'kode' => strtoupper(Str::random(6)),
                    'nama' => $product->jenis . ' ' . $perhiasan->jenis,
                    'tanggal' => now()->toDateString(),
                    'jumlah' => rand(1, 10),
                    'berat_kotor' => round(rand(100, 300) / 100, 3), // 1.00 - 3.00 gr
                    'berat_bersih' => round(rand(80, 290) / 100, 3),  // 0.80 - 2.90 gr
                    'berat_kitir' => round(rand(5, 50) / 100, 3),     // 0.05 - 0.50 gr
                    'pergram' => rand(100000, 500000), // 100.000 - 500.000 IDR
                    'real' => rand(0, 10) // Optional real value
                ]);
            }
        }
    }
}
