<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\PengenaanSP;

class PengenaanSPExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'No Surat',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Nama Pelaku Usaha',
            'Sanksi',
        ];
    }

    public function collection()
    {
        return $this->data->map(function ($d) {
            return [
                $d->no_surat,
                $d->tanggal_mulai,
                $d->tanggal_selesai,
                $d->pelaku_usaha->nama ?? '-',
                $d->sanksi->nama ?? '-',
            ];
        });
    }
}
