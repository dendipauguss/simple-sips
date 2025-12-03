<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    protected $guarded = ['id'];

    public function files()
    {
        return $this->hasMany(FilesModel::class, 'tabel_id')
            ->where('tabel_name', 'perusahaan');
    }
}
