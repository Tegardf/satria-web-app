<?php

namespace Database\Seeders;

use App\Models\Gesek;
use App\Models\Perhiasan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GesekSeeder extends Seeder
{

    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $perhiasanIds = Perhiasan::pluck('id')->toArray();

        foreach (range(1, 20) as $index) {
            Gesek::create([
                'id_perhiasan' => $faker->randomElement($perhiasanIds),
                'nama_bank' => $faker->randomElement(['BCA', 'Mandiri', 'BRI', 'BNI']),
                'nama' => $faker->name,
                'masuk' => $masuk = $faker->numberBetween(100000, 1000000),
                'keluar' => $keluar = $faker->numberBetween(0, $masuk),
            ]);
        }
    }
}
