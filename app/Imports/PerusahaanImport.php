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
            'alamat' => 'Import Excel',
            'jenis_perusahaan' => $row['jenis_perusahaan'],
        ]);
    }
}
