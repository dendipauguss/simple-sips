<?php

namespace App\Imports;

use App\Models\Perusahaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PerusahaanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Perusahaan([
            'nama' => $row['nama_perusahaan'],
            'alamat' => $row['alamat'],
            'jenis_id' => $row['jenis_perusahaan'],
        ]);
    }
}
