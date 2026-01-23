<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanksi extends Model
{
    use HasFactory;
    protected $table = 'sanksi';

    protected $guarded = ['id'];

    // public function perintah_sanksi()
    // {
    //     return $this->hasMany(PerintahSanksi::class);
    // }

    public function pengenaan_sp()
    {
        return $this->belongsToMany(
            PengenaanSP::class,
            'pengenaan_sp_sanksi',
            'pengenaan_sp_id'
        )->using(PengenaanSPSanksi::class)
            ->withPivot('nominal_denda', 'status')
            ->withTimestamps();
    }

    public function pengenaan_sp_sanksi()
    {
        return $this->hasMany(PengenaanSPSanksi::class);
    }

    public function pengenaan_sp_eskalasi(){
        return $this->hasMany(PengenaanSPEskalasi::class);
    }
}
