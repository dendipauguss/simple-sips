<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\PengenaanSP;
use App\Models\JenisPelakuUsaha;
use App\Models\PelakuUsaha;
use App\Models\JenisPelanggaran;
use App\Models\KategoriSP;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class PengenaanSPImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // =========================
        // NORMALISASI DATA
        // =========================
        $jenisPelakuNama = str_replace('_', ' ', strtolower(trim($row['jenis_pelaku_usaha'])));
        $jenisPelakuNama = preg_replace('/\s+/', ' ', $jenisPelakuNama);
        $jenisPelakuNama = ucwords($jenisPelakuNama);
        $pelakuNama = strtoupper(trim($row['pelaku_usaha']));

        // $jenisPelaku = JenisPelakuUsaha::whereRaw('LOWER(nama) = ?', [$jenisPelakuNama])->first();

        if ($jenisPelakuNama === "Calon Pedagang Fisik Kripto") {
            return null;
        }

        $jenisPelaku = JenisPelakuUsaha::firstOrCreate(['nama' => $jenisPelakuNama]);
        // $pelakuUsaha = PelakuUsaha::whereRaw('UPPER(nama) = ?', [trim($row['pelaku_usaha'])])->first();
        $pelakuUsaha = PelakuUsaha::firstOrCreate([
            'nama' => $pelakuNama,
            'jenis_id' => $jenisPelaku->id
        ]);


        // =========================
        // MAPPING MASTER DATA
        // =========================

        $jenisPelanggaranNama = str_replace('_', ' ', strtolower(trim($row['jenis_pelanggaran'])));
        $jenisPelanggaran = JenisPelanggaran::whereRaw('LOWER(nama) = ?', [$jenisPelanggaranNama])->first();

        $kategoriNama = str_replace('_', ' ', strtolower(trim($row['kategori_sp'])));
        $kategoriSp = KategoriSP::whereRaw('LOWER(nama) = ?', [$kategoriNama])->first();

        // ❌ Jika salah satu tidak ditemukan → skip
        if (!$jenisPelaku || !$pelakuUsaha || !$jenisPelanggaran || !$kategoriSp) {
            return null;
        }

        if (empty($row['tanggal_mulai'])) {
            return null;
        }

        $tanggalMulai = $this->parseTanggal($row['tanggal_mulai']);

        // Jika parsing gagal → skip
        if (!$tanggalMulai) {
            return null;
        }

        // ✅ tanggal_selesai
        if (!empty($row['tanggal_selesai'])) {
            $tanggalSelesai = $this->parseTanggal($row['tanggal_selesai']);

            if (!$tanggalSelesai) {
                $tanggalSelesai = $tanggalMulai->copy()->addDays(30);
            }
        } else {
            $tanggalSelesai = $tanggalMulai->copy()->addDays(30);
        }

        if (!empty($row['tanggapan'])) {
            $status_tanggapan = 'sudah_ditanggapi';
        } else {
            $status_tanggapan = 'belum_ditanggapi';
        }


        return new PengenaanSp([
            'no_surat'              => $row['no_surat'],
            'tanggal_mulai'         => $tanggalMulai,
            'tanggal_selesai'       => $tanggalSelesai,
            'sanksi_id'             => 1,
            'jenis_pelaku_usaha_id' => $jenisPelaku->id,
            'pelaku_usaha_id'       => $pelakuUsaha->id,
            'jenis_pelanggaran_id'  => $jenisPelanggaran->id,
            'kategori_sp_id'        => $kategoriSp->id,
            'detail_pelanggaran'    => $row['detail_pelanggaran'],
            'tanggapan'             => $row['tanggapan'],
            'status_surat'          => $status_tanggapan,
            'user_id'               => 2,
        ]);
    }

    private function parseTanggal($value)
    {
        if (empty($value)) {
            return null;
        }

        // Jika numeric (Excel date)
        if (is_numeric($value)) {
            return Carbon::instance(
                ExcelDate::excelToDateTimeObject($value)
            );
        }

        // Bersihkan spasi & karakter aneh
        $value = trim($value);

        // Coba beberapa format
        $formats = ['d/m/Y', 'j/n/Y', 'Y-m-d'];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $value);
            } catch (\Exception $e) {
                // lanjut ke format berikutnya
            }
        }

        // Fallback terakhir
        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
