<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelanggaran';

    protected $guarded = ['id'];

    public function pengenaan_sp()
    {
        return $this->hasMany(PengenaanSP::class, 'jenis_pelanggaran_id');
    }

    public function dasar_pengenaan_sanksi()
    {
        return $this->belongsTo(DasarPengenaanSanksi::class, 'dasar_pengenaan_sanksi_id');
    }
}
