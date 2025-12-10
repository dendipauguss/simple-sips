<?php

namespace App\Imports;

use App\Models\KategoriSP;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KategoriSPImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        switch ($row['jenis_pelanggaran']) {
            case 'direktur_kepatuhan':
                $row['jenis_pelanggaran'] = 1;
                break;
            case 'dttot':
                $row['jenis_pelanggaran'] = 2;
                break;
            case 'integritas_keuangan':
                $row['jenis_pelanggaran'] = 3;
                break;
            case 'laporan_kegiatan':
                $row['jenis_pelanggaran'] = 4;
                break;
            case 'laporan_keuangan':
                $row['jenis_pelanggaran'] = 5;
                break;
            case 'laporan_transaksi':
                $row['jenis_pelanggaran'] = 6;
                break;
            case 'margin':
                $row['jenis_pelanggaran'] = 7;
                break;
            case 'market_maker':
                $row['jenis_pelanggaran'] = 8;
                break;
            case 'pemeriksaan':
                $row['jenis_pelanggaran'] = 9;
                break;
            case 'teguran_tenda':
                $row['jenis_pelanggaran'] = 10;
                break;
            case 'aset_kripto_diluar_ketentuan':
                $row['jenis_pelanggaran'] = 11;
                break;
            default:
                $row['jenis_pelanggaran'] = 0;
                break;
        }
        return new KategoriSP([
            'nama' => $row['nama_kategori_sp'],
            'jenis_pelanggaran_id' => $row['jenis_pelanggaran']
        ]);
    }
}
