<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\PengenaanSp;
use App\Models\JenisPelakuUsaha;
use App\Models\PelakuUsaha;
use App\Models\JenisPelanggaran;
use App\Models\KategoriSp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PengenaanSPImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1️⃣ Mapping Jenis Pelaku Usaha
        $jenisPelaku = JenisPelakuUsaha::where('nama', trim($row['jenis_pelaku_usaha']))->first();
        // $jenisPelaku = JenisPelakuUsaha::where('nama', trim($row['jenis_pelaku_usaha']))->firstOrCreate();

        // 2️⃣ Mapping Pelaku Usaha
        $pelaku = PelakuUsaha::where('nama', trim($row['pelaku_usaha']))->first();

        // 3️⃣ Mapping Jenis Pelanggaran
        $jenisPelanggaran = JenisPelanggaran::where('nama', trim($row['jenis_pelanggaran']))->first();

        // 4️⃣ Mapping Kategori SP
        $kategoriSp = KategoriSp::where('nama', trim($row['kategori_sp']))->first();

        // ❌ Jika salah satu tidak ditemukan → batalkan
        if (!$jenisPelaku || !$pelaku || !$jenisPelanggaran || !$kategoriSp) {
            return null; // atau throw Exception
        }

        return new PengenaanSp([
            'no_surat'               => $row['no_surat'],
            'tanggal_mulai'          => \Carbon\Carbon::parse($row['tanggal_mulai']),
            'tanggal_selesai'        => \Carbon\Carbon::parse($row['tanggal_selesai']),
            'jenis_pelaku_usaha_id'  => $jenisPelaku->id,
            'pelaku_usaha_id'        => $pelaku->id,
            'sanksi_id'              => 1,
            'jenis_pelanggaran_id'   => $jenisPelanggaran->id,
            'kategori_sp_id'         => $kategoriSp->id,
            'detail_pelanggaran'     => $row['detail_pelanggaran'],
            'tanggapan'              => $row['tanggapan'],
        ]);
    }
}
