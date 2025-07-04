<?php

namespace Database\Seeders;

use App\Models\History;
use App\Models\Pembelian;
use App\Models\Perhiasan;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perhiasans = Perhiasan::all();
        $products = Product::all();
        $histories = History::all();

        // Create sample pembelian entries
        foreach ($histories as $history) {
            foreach ($perhiasans as $perhiasan) {
                foreach ($products as $product) {
                    $randomDate = Carbon::now()->subDays(rand(0, 90));
                    Pembelian::create([
                        'id_bulan' => $randomDate->format('n'),
                        'id_perhiasan' => $perhiasan->id,
                        'id_produk' => $product->id,
                        'nama_barang' => $product->jenis . ' ' . $perhiasan->jenis,
                        'tanggal'=>$randomDate->format('Y-m-d'),
                        'kadar' => rand(70, 99),
                        'berat' => rand(1, 100),
                        'kode' => rand(1000, 9999),
                        'pergram_beli' => rand(800000, 1200000),
                        'pergram_jual' => rand(1200000, 1600000),
                        'keterangan' => 'Contoh data pembelian',
                        'sales' => fake()->name,
                    ]);
                }
            }
        }
    }
}
