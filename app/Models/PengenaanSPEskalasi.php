<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengenaanSPEskalasi extends Model
{
    use HasFactory;

    protected $table = 'pengenaan_sp_eskalasi';

    protected $guarded = ['id'];

    public function pengenaan_sp()
    {
        return $this->belongsTo(PengenaanSP::class, 'pengenaan_sp_id');
    }

    public function sanksi()
    {
        return $this->belongsTo(Sanksi::class);
    }

    public function files()
    {
        return $this->hasMany(Files::class, 'table_id')
            ->where('table_name', 'pengenaan_sp_eskalasi');
    }
}
