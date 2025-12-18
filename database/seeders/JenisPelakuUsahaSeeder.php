<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPelakuUsaha;

class JenisPelakuUsahaSeeder extends Seeder
{
    public function run(): void
    {
        JenisPelakuUsaha::create([
            'nama' => 'Bank Penyimpan Margin'
        ]);

        JenisPelakuUsaha::create([
            'nama' => 'Bursa Berjangka'
        ]);

        JenisPelakuUsaha::create([
            'nama' => 'Kliring Berjangka'
        ]);

        JenisPelakuUsaha::create([
            'nama' => 'Pedagang Berjangka'
        ]);

        JenisPelakuUsaha::create([
            'nama' => 'Pedagang Fisik Emas'
        ]);

        JenisPelakuUsaha::create([
            'nama' => 'Pedagang Fisik Timah'
        ]);

        JenisPelakuUsaha::create([
            'nama' => 'Pialang Berjangka'
        ]);

        JenisPelakuUsaha::create([
            'nama' => "Calon Pedagang Aset Kripto"
        ]);
    }
}
