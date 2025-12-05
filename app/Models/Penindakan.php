<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penindakan extends Model
{
    use HasFactory;

    protected $table = 'penindakan';

    protected $guarded = ['id'];

    public function perintah()
    {
        return $this->belongsToMany(PerintahSanksi::class, 'penindakan_perintah_sanksi')
            ->withPivot('status', 'id')
            ->withTimestamps();
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
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
        return $this->hasMany(FilesModel::class, 'table_id')
            ->where('table_name', 'penindakan');
    }

    public function perihal()
    {
        return $this->belongsTo(Perihal::class);
    }
}
