<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PengenaanSPSanksi extends Pivot
{
    use HasFactory;

    protected $table = 'pengenaan_sp_sanksi';

    protected $fillable = [
        'pengenaan_sp_id',
        'sanksi_id',
        'nominal_denda',
        'status',
    ];

    public function pengenaan_sp()
    {
        return $this->belongsTo(PengenaanSP::class, 'pengenaan_sp_id');
    }

    public function sanksi()
    {
        return $this->belongsTo(Sanksi::class);
    }
}
