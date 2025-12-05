<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penindakan;

class PerintahSanksi extends Model
{
    use HasFactory;

    protected $table = 'perintah_sanksi';

    protected $guarded = ['id'];

    public function sanksi()
    {
        return $this->belongsTo(Sanksi::class);
    }

    public function penindakan()
    {
        return $this->belongsToMany(PengenaanSanksi::class, 'pengenaan_perintah_sanksi');
    }
}
