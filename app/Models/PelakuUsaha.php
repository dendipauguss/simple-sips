<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelakuUsaha extends Model
{
    use HasFactory;

    protected $table = 'pelaku_usaha';

    protected $guarded = ['id'];

    public function files()
    {
        return $this->hasMany(Files::class, 'tabel_id')
            ->where('tabel_name', 'pelaku_usaha');
    }

    public function jenis_pelaku_usaha()
    {
        return $this->belongsTo(JenisPelakuUsaha::class, 'jenis_id');
    }
}
