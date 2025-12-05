<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $guarded = ['id'];

    public function relation()
    {
        return $this->morphTo(null, 'table_name', 'table_id');
    }
}
