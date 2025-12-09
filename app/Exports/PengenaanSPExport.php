<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\PengenaanSP;

class PengenaanSPExport implements FromCollection
{
    protected $mulai;
    protected $selesai;

    public function __construct($mulai = null, $selesai = null)
    {
        $this->mulai = $mulai;
        $this->selesai = $selesai;
    }

    public function collection()
    {
        $query = PengenaanSP::query();

        if ($this->mulai && $this->selesai) {
            $query->whereBetween('tanggal_mulai', [
                $this->mulai,
                $this->selesai
            ]);
        }

        return $query->orderBy('tanggal_selesai', 'asc')->get();
    }
}
