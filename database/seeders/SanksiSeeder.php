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
            'kode_surat' => 'SP'
        ]);
        Sanksi::create([
            'nama' => 'Denda administratif',
            'kode_surat' => 'DA'
        ]);
        Sanksi::create([
            'nama' => 'Pembatasan kegiatan usaha',
            'kode_surat' => 'BTS'
        ]);
        Sanksi::create([
            'nama' => 'Pembekuan kegiatan usaha',
            'kode_surat' => 'BKU'
        ]);
        Sanksi::create([
            'nama' => 'Pencabutan izin usaha',
            'kode_surat' => 'CBTU'
        ]);
        Sanksi::create([
            'nama' => 'Pembatalan persetujuan',
            'kode_surat' => 'BTLP'
        ]);
        Sanksi::create([
            'nama' => 'Pembatalan sertifikat pendaftaran',
            'kode_surat' => 'BTLSP'
        ]);
    }
}
