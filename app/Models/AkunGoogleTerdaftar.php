<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunGoogleTerdaftar extends Model
{
    use HasFactory;

    protected $table = 'akun_google_terdaftar';

    protected $guarded = ['id'];
}
