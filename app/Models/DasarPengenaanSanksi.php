<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DasarPengenaanSanksi extends Model
{
    use HasFactory;

    protected $table = 'dasar_pengenaan_sanksi';

    protected $guarded = ['id'];

    public function jenis_pelanggaran()
    {
        return $this->hasMany(JenisPelanggaran::class, 'dasar_pengenaan_sanksi_id');
    }
}
