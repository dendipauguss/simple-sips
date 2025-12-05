<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPerusahaan extends Model
{
    use HasFactory;

    protected $table = 'jenis_perusahaan';

    protected $guarded = ['id'];
}
