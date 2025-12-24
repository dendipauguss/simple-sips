<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaDinas extends Model
{
    use HasFactory;

    protected $table = 'nota_dinas';

    protected $guarded = ['id'];

    public function pengenaan_sp()
    {
        return $this->hasMany(PengenaanSP::class, 'nota_dinas_id');
    }
}
