<?php

namespace App\Imports;

use App\Models\PelakuUsaha;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PelakuUsahaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        switch ($row['jenis_pelaku_usaha']) {
            case 'bank':
                $row['jenis_pelaku_usaha'] = 1;
                break;
            case 'bursa_berjangka':
                $row['jenis_pelaku_usaha'] = 2;
                break;
            case 'kliring_berjangka':
                $row['jenis_pelaku_usaha'] = 3;
                break;
            case 'pedagang_berjangka':
                $row['jenis_pelaku_usaha'] = 4;
                break;
            case 'pedagang_fisik_emas':
                $row['jenis_pelaku_usaha'] = 5;
                break;
            case 'pedagang_fisik_timah':
                $row['jenis_pelaku_usaha'] = 6;
                break;
            case 'pialang_berjangka':
                $row['jenis_pelaku_usaha'] = 7;
                break;
            default:
                $row['jenis_pelaku_usaha'] = 0;
                break;
        }
        return new PelakuUsaha([
            'nama' => !empty($row['nama_pelaku_usaha']) ? $row['nama_pelaku_usaha'] : 'Data Excel kosong',
            'jenis_id' => $row['jenis_pelaku_usaha']
        ]);
    }
}
