<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DasarPengenaanSanksi;

class DasarPengenaanSanksiSeeder extends Seeder
{
    public function run(): void
    {
        DasarPengenaanSanksi::create([
            'nama' => 'Hasil Pengawasan'
        ]);

        DasarPengenaanSanksi::create([
            'nama' => 'Hasil Pemeriksaan'
        ]);
    }
}
