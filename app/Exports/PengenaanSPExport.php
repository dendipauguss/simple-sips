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
            'No',
            'No Surat',
            'Tanggal Surat',
            'Bulan',
            'Bentuk Sanksi',
            'Jenis Pelaku Usaha',
            'Perusahaan',
            'Jenis Pelanggaran',
            'Kategori Sanksi',
            'Detail Pelanggaran',
            'Jangka Waktu',
            'Tanggal Jatuh Tempo',
            'Tanggapan/Perbaikan Atas Sanksi'
        ];
    }

    public function collection()
    {
        return $this->data->map(function ($d, $index) {
            return [
                $index + 1,
                $d->no_surat,
                $d->tanggal_mulai,
                \Carbon\Carbon::parse($d->tanggal_mulai)->translatedFormat('Y'),
                $d->sanksi->nama ?? '-',
                $d->pelaku_usaha->jenis_pelaku_usaha->nama ?? '-',
                $d->pelaku_usaha->nama ?? '-',
                $d->jenis_pelanggaran->nama,
                $d->kategori_sp->nama,
                $d->detail_pelanggaran,
                \Carbon\Carbon::parse($d->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($d->tanggal_selesai)),
                \Carbon\Carbon::parse($d->tanggal_selesai)->translatedFormat('l, d F Y'),
                $d->tanggapan,
            ];
        });
    }
}
