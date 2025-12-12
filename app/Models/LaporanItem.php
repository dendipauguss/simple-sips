<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanItem extends Model
{
    use HasFactory;

    protected $table = 'laporan_item';

    protected $fillable = [
        'laporan_id',
        'pengenaan_sp_id'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    public function pengenaan_sp()
    {
        return $this->belongsTo(PengenaanSP::class);
    }
}
