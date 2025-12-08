<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PelakuUsaha;

class PelakuUsahaSeeder extends Seeder
{
    public function run()
    {
        PelakuUsaha::create([
            'nama' => 'AJAIB FUTURES ASIA',
            'jenis_id' => 5
        ]);
        PelakuUsaha::create([
            'nama' => 'ALPHA CENTAURI BERJANGKA',
            'jenis_id' => 5
        ]);
        PelakuUsaha::create([
            'nama' => 'GENESIS GEMILANG FUTURES',
            'jenis_id' => 5
        ]);
    }
}
