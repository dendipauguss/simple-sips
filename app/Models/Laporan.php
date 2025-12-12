<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'bulan',
        'tahun',
        'catatan',
        'status_disetujui'
    ];

    public function items()
    {
        return $this->hasMany(LaporanItem::class);
    }

    public function pengenaan_sp()
    {
        return $this->belongsToMany(PengenaanSP::class, 'laporan_item', 'laporan_id', 'pengenaan_sp_id');
    }
}
