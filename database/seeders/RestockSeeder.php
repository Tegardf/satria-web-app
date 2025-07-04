<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perhiasans = DB::table('perhiasans')->pluck('id');
        $products = DB::table('products')->pluck('id');

        foreach ($perhiasans as $id_perhiasan) {
            foreach ($products as $id_produk) {
                for ($i = 0; $i < 2; $i++) {
                    DB::table('restocks')->insert([
                        'id_perhiasan' => $id_perhiasan,
                        'id_produk' => $id_produk,
                        'model' => fake()->word(),
                        'berat' => fake()->randomFloat(3, 1, 20), // 1.000 to 20.000 gr
                        'ukuran' => fake()->randomElement(['S', 'M', 'L', 'XL']),
                        'kadar' => fake()->numberBetween(30, 100), // gold percentage
                        'jumlah' => fake()->numberBetween(1, 10),
                        'status' => fake()->boolean(30), // 30% chance it's true
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
