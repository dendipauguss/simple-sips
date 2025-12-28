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
            'nama' => 'Direktur Kepatuhan',
            'dasar_pengenaan_sanksi_id' => 1
        ]);

        JenisPelanggaran::create([
            'nama' => 'DTTOT',
            'dasar_pengenaan_sanksi_id' => 1
        ]);

        JenisPelanggaran::create([
            'nama' => 'Integritas Keuangan',
            'dasar_pengenaan_sanksi_id' => 1
        ]);

        JenisPelanggaran::create([
            'nama' => 'Laporan Kegiatan',
            'dasar_pengenaan_sanksi_id' => 1
        ]);

        JenisPelanggaran::create([
            'nama' => 'Laporan Keuangan',
            'dasar_pengenaan_sanksi_id' => 1
        ]);

        JenisPelanggaran::create([
            'nama' => 'Laporan Transaksi',
            'dasar_pengenaan_sanksi_id' => 1
        ]);

        JenisPelanggaran::create([
            'nama' => 'Margin',
            'dasar_pengenaan_sanksi_id' => 1
        ]);

        JenisPelanggaran::create([
            'nama' => 'Market Maker',
            'dasar_pengenaan_sanksi_id' => 1
        ]);

        JenisPelanggaran::create([
            'nama' => 'Pemeriksaan',
            'dasar_pengenaan_sanksi_id' => 2
        ]);

        JenisPelanggaran::create([
            'nama' => 'Teguran Denda',
            'dasar_pengenaan_sanksi_id' => 1
        ]);
    }
}
