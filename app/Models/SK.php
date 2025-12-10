<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SK extends Model
{
    use HasFactory;

    protected $table = 'sk';

    protected $guarded = ['id'];

    public function pengenaan_sp()
    {
        return $this->belongsTo(PengenaanSP::class);
    }

    public function file()
    {
        return $this->hasOne(Files::class, 'table_id')
            ->where('table_name', 'sk');
    }
}
