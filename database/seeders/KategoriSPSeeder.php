<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriSP;

class KategoriSPSeeder extends Seeder
{
    public function run()
    {
        KategoriSP::create([
            'nama' => 'Data Pengurus Berbeda',
            'jenis_pelanggaran_id' => 1
        ]);

        KategoriSP::create([
            'nama' => 'Direksi bukan WPB',
            'jenis_pelanggaran_id' => 1
        ]);

        KategoriSP::create([
            'nama' => 'Terlambat laporan nihil',
            'jenis_pelanggaran_id' => 2
        ]);

        KategoriSP::create([
            'nama' => 'Ketidaksesuaian Ekuitas',
            'jenis_pelanggaran_id' => 3
        ]);

        KategoriSP::create([
            'nama' => 'Keterlambatan Lapkeg Tahunan',
            'jenis_pelanggaran_id' => 4
        ]);

        KategoriSP::create([
            'nama' => 'Keterlambatan LapTran Bulanan',
            'jenis_pelanggaran_id' => 5
        ]);

        KategoriSP::create([
            'nama' => 'Keterlambatan Penyesuaian Margin',
            'jenis_pelanggaran_id' => 6
        ]);

        KategoriSP::create([
            'nama' => 'Tidak Membukukan Transaksi',
            'jenis_pelanggaran_id' => 7
        ]);

        KategoriSP::create([
            'nama' => 'Hasil Pemeriksaan',
            'jenis_pelanggaran_id' => 8
        ]);
    }
}
