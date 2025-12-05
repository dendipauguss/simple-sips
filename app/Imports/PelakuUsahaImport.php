<?php

namespace App\Imports;

use App\Models\PelakuUsaha;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PelakuUsahaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new PelakuUsaha([
            'nama' => $row['nama_perusahaan'],
            'alamat' => $row['alamat'],
            'jenis_id' => $row['jenis_perusahaan'],
        ]);
    }
}
