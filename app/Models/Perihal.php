<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perihal extends Model
{
    use HasFactory;

    protected $table = 'perihal';

    protected $guarded = ['id'];

    public function penindakan()
    {
        return $this->hasMany(Penindakan::class);
    }
}
