<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSP extends Model
{
    use HasFactory;

    protected $table = 'kategori_sp';

    protected $guarded = ['id'];

    public function jenis_pelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class);
    }
}
