<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPelakuUsaha extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelaku_usaha';

    protected $guarded = ['id'];

    public function pelaku_usaha()
    {
        return $this->hasMany(PelakuUsaha::class, 'jenis_id');
    }

    public function pengenaan_sp()
    {
        return $this->hasMany(PengenaanSP::class);
    }
}
