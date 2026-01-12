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
            'nama' => 'Denda Administratif',
            'kode_surat' => 'DA'
        ]);
        Sanksi::create([
            'nama' => 'Pembatasan Kegiatan Usaha',
            'kode_surat' => 'BTS'
        ]);
        Sanksi::create([
            'nama' => 'Pembekuan Kegiatan Usaha',
            'kode_surat' => 'BKU'
        ]);
        Sanksi::create([
            'nama' => 'Pencabutan Izin Usaha',
            'kode_surat' => 'CBTU'
        ]);
        Sanksi::create([
            'nama' => 'Pembatalan Persetujuan',
            'kode_surat' => 'BTLP'
        ]);
        Sanksi::create([
            'nama' => 'Pembatalan Sertifikat Pendaftaran',
            'kode_surat' => 'BTLSP'
        ]);
    }
}
