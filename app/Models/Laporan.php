<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(LaporanItem::class);
    }

    public function pengenaan_sp()
    {
        return $this->belongsToMany(PengenaanSP::class, 'laporan_item', 'laporan_id', 'pengenaan_sp_id');
    }

    public function pelaku_usaha()
    {
        return $this->belongsTo(PelakuUsaha::class, 'pelaku_usaha_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
