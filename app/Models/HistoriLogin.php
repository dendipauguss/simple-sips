<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriLogin extends Model
{
    use HasFactory;

    protected $table = 'histori_login';

    protected $guarded = ['id'];
}
