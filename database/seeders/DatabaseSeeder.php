<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $usersSeed = [
            [
                'name' => 'Test admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('1234567890'),
                'role' => 'admin',
            ],[
                'name' => 'Test User',
                'email' => 'user@gmail.com',
                'password' => bcrypt('1234567890'),
                'role' => 'user',
            ]
        ];
        foreach ($usersSeed as $userData) {
            User::factory()->create($userData);
        }
        $this->call([
            PerhiasanSeeder::class,
            ProductSeeder::class,
            RestockSeeder::class,
            StockSeeder::class,
            HistorysSeeder::class,
            PembelianSeeder::class,
            PengeluaranSeeder::class,
            PenjualanLainSeeder::class,
            PricelistSeeder::class,
            GesekSeeder::class,
        ]);
    }
}
