<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPerusahaan;

class JenisPerusahaanSeeder extends Seeder
{
    public function run(): void
    {
        JenisPerusahaan::create([
            'nama' => 'Pialang Berjangka'
        ]);

        JenisPerusahaan::create([
            'nama' => 'Pedagang Berjangka'
        ]);

        JenisPerusahaan::create([
            'nama' => 'Pedagang Fisik Emas Digital'
        ]);

        JenisPerusahaan::create([
            'nama' => 'Bursa Berjangka'
        ]);

        JenisPerusahaan::create([
            'nama' => 'Lembaga Kliring Berjangka'
        ]);
    }
}
