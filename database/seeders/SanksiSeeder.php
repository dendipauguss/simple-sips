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
            'kode_surat' => 'SP',
            'urutan' => 1
        ]);
        Sanksi::create([
            'nama' => 'Denda Administratif',
            'kode_surat' => 'DA',
            'urutan' => 2
        ]);
        Sanksi::create([
            'nama' => 'Pembatasan Kegiatan Usaha',
            'kode_surat' => 'BTS',
            'urutan' => 3
        ]);
        Sanksi::create([
            'nama' => 'Pembekuan Kegiatan Usaha',
            'kode_surat' => 'BKU',
            'urutan' => 4
        ]);
        Sanksi::create([
            'nama' => 'Pencabutan Izin Usaha',
            'kode_surat' => 'CBTU',
            'urutan' => 5
        ]);
        Sanksi::create([
            'nama' => 'Pembatalan Persetujuan',
            'kode_surat' => 'BTLP',
            'urutan' => 6
        ]);
        Sanksi::create([
            'nama' => 'Pembatalan Sertifikat Pendaftaran',
            'kode_surat' => 'BTLSP',
            'urutan' => 7
        ]);
    }
}
