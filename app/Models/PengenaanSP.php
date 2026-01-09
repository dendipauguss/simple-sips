<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengenaanSP extends Model
{
    use HasFactory;

    protected $table = 'pengenaan_sp';

    protected $guarded = ['id'];

    public function jenis_pelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'jenis_pelanggaran_id');
    }

    public function kategori_sp()
    {
        return $this->belongsTo(KategoriSP::class);
    }

    public function jenis_pelaku_usaha()
    {
        return $this->belongsTo(JenisPelakuUsaha::class);
    }

    public function pelaku_usaha()
    {
        return $this->belongsTo(PelakuUsaha::class);
    }

    public function nota_dinas()
    {
        return $this->belongsTo(NotaDinas::class, 'nota_dinas_id');
    }

    public function sanksi()
    {
        return $this->belongsToMany(
            Sanksi::class,
            'pengenaan_sp_sanksi',
            'pengenaan_sp_id'
        )->using(PengenaanSPSanksi::class)
            ->withPivot('nominal_denda', 'status')
            ->withTimestamps();
    }

    public function pengenaan_sp_sanksi()
    {
        return $this->hasMany(PengenaanSPSanksi::class, 'pengenaan_sp_id');
    }

    public function file()
    {
        return $this->hasOne(Files::class, 'table_id')
            ->where('table_name', 'pengenaan_sp');
    }

    public function files()
    {
        return $this->hasMany(Files::class, 'table_id')
            ->where('table_name', 'pengenaan_sp');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sk()
    {
        return $this->hasOne(SK::class);
    }

    public function laporan()
    {
        return $this->belongsToMany(
            Laporan::class,
            'laporan_item',
            'pengenaan_sp_id',
            'laporan_id'
        );
    }
}
