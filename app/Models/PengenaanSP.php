<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengenaanSP extends Model
{
    use HasFactory;

    protected $table = 'pengenaan_sp';

    protected $guarded = ['id'];

    public function jenis_pelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class);
    }

    public function kategori_sp()
    {
        return $this->belongsTo(KategoriSP::class);
    }

    public function jenis_pelaku_usaha()
    {
        return $this->belongsTo(JenisPelakuUsaha::class);
    }

    public function pelaku_usaha()
    {
        return $this->belongsTo(PelakuUsaha::class);
    }

    public function file()
    {
        return $this->hasOne(Files::class, 'table_id')
            ->where('table_name', 'pengenaan_sp');
    }
}
