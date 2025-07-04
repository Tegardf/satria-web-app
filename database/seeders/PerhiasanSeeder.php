<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Perhiasan;

class PerhiasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Perhiasan::insert([
            ['jenis' => 'Perhiasan Tua'],
            ['jenis' => 'Perhiasan Muda'],
        ]);
    }
}
