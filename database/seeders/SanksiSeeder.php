<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sanksi;

class SanksiSeeder extends Seeder
{
    public function run()
    {
        Sanksi::create([
            'nama' => 'Peringatan Tertulis',
        ]);
        Sanksi::create([
            'nama' => 'Denda administratif, yaitu kewajiban membayar sejumlah uang tertentu',
        ]);
        Sanksi::create([
            'nama' => 'Pembatasan kegiatan usaha',
        ]);
        Sanksi::create([
            'nama' => 'Pembekuan kegiatan usaha',
        ]);
        Sanksi::create([
            'nama' => 'Pencabutan izin usaha',
        ]);
        Sanksi::create([
            'nama' => 'Pencabutan izin',
        ]);
        Sanksi::create([
            'nama' => 'Pembatalan persetujuan',
        ]);
        Sanksi::create([
            'nama' => 'Pembatalan sertifikat pendaftaran',
        ]);
    }
}
