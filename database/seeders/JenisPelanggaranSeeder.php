<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPelanggaran;

class JenisPelanggaranSeeder extends Seeder
{
    public function run()
    {
        JenisPelanggaran::create([
            'nama' => 'Direktur Kepatuhan'
        ]);

        JenisPelanggaran::create([
            'nama' => 'DTTOT'
        ]);

        JenisPelanggaran::create([
            'nama' => 'Integritas Keuangan'
        ]);

        JenisPelanggaran::create([
            'nama' => 'Laporan Kegiatan'
        ]);

        JenisPelanggaran::create([
            'nama' => 'Laporan Keuangan'
        ]);

        JenisPelanggaran::create([
            'nama' => 'Laporan Transaksi'
        ]);

        JenisPelanggaran::create([
            'nama' => 'Margin'
        ]);

        JenisPelanggaran::create([
            'nama' => 'Market Maker'
        ]);

        JenisPelanggaran::create([
            'nama' => 'Pemeriksaan'
        ]);

        JenisPelanggaran::create([
            'nama' => 'Teguran Tenda'
        ]);

        JenisPelanggaran::create([
            'nama' => 'Aset Kripto Diluar Ketentuan'
        ]);
    }
}
