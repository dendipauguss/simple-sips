<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengenaanSP;
use Carbon\Carbon;

class PengenaanSPSeeder extends Seeder
{
    public function run()
    {
        PengenaanSP::create([
            'no_surat' => 'UD.02.01/001/BAPPEBTI/SP/10/2023',
            'sanksi_id' => 1,
            'tanggal_mulai' => Carbon::create(2023, 10, 26)->toDateTimeString(),
            'tanggal_selesai' => Carbon::create(2023, 11, 26)->toDateTimeString(),
            'jenis_pelaku_usaha_id' => 1,
            'pelaku_usaha_id' => 1,
            'jenis_pelanggaran_id' => 1,
            'kategori_sp_id' => 1,
            'detail_pelanggaran' => 'MBD per 30 Nov 2022 Rp 269.539.748,11',
            'tanggapan' => 'PT ATPF telah dikenakan sanksi administratif berupa pembatasan usaha sejak 9 Februari 2023 sd 9 Mei 2023',
            'user_id' => 2
        ]);

        PengenaanSP::create([
            'no_surat' => 'UD.02.01/002/BAPPEBTI/SP/10/2024',
            'sanksi_id' => 1,
            'tanggal_mulai' => Carbon::create(2024, 10, 26)->toDateTimeString(),
            'tanggal_selesai' => Carbon::create(2024, 11, 26)->toDateTimeString(),
            'jenis_pelaku_usaha_id' => 1,
            'pelaku_usaha_id' => 1,
            'jenis_pelanggaran_id' => 1,
            'kategori_sp_id' => 1,
            'detail_pelanggaran' => 'MBD per 30 Nov 2022 Rp 269.539.748,11',
            'tanggapan' => 'PT ATPF telah dikenakan sanksi administratif berupa pembatasan usaha sejak 9 Februari 2023 sd 9 Mei 2023',
            'user_id' => 2
        ]);

        PengenaanSP::create([
            'no_surat' => 'UD.02.01/003/BAPPEBTI/SP/10/2025',
            'sanksi_id' => 1,
            'tanggal_mulai' => Carbon::create(2025, 10, 26)->toDateTimeString(),
            'tanggal_selesai' => Carbon::create(2025, 11, 26)->toDateTimeString(),
            'jenis_pelaku_usaha_id' => 1,
            'pelaku_usaha_id' => 1,
            'jenis_pelanggaran_id' => 1,
            'kategori_sp_id' => 1,
            'detail_pelanggaran' => 'MBD per 30 Nov 2022 Rp 269.539.748,11',
            'tanggapan' => 'PT ATPF telah dikenakan sanksi administratif berupa pembatasan usaha sejak 9 Februari 2023 sd 9 Mei 2023',
            'user_id' => 2
        ]);
    }
}
