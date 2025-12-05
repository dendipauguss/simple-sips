<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengenaanSanksi extends Model
{
    use HasFactory;

    protected $table = 'pengenaan_sanksi';

    protected $guarded = ['id'];

    public function perintah()
    {
        return $this->belongsToMany(PerintahSanksi::class, 'pengenaan_perintah_sanksi')
            ->withPivot('status', 'id')
            ->withTimestamps();
    }

    public function pelaku_usaha()
    {
        return $this->belongsTo(PelakuUsaha::class);
    }

    public function sanksi()
    {
        return $this->belongsTo(Sanksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function files()
    {
        return $this->hasMany(Files::class, 'table_id')
            ->where('table_name', 'pengenaan_sanksi');
    }

    public function perihal()
    {
        return $this->belongsTo(Perihal::class);
    }
}
