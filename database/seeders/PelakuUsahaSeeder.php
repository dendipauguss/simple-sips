<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PelakuUsaha;

class PelakuUsahaSeeder extends Seeder
{
    public function run()
    {
        PelakuUsaha::create([
            'nama' => 'AJAIB FUTURES ASIA',
            'alamat' => 'Soho @Podomoro City, Lt. 23 Unit 21, Jl. Letjen S. Parman Kav. 28 kelurahan TANJUNG DUREN SELATAN kecamatan GROGOL PETAMBURAN kota JAKARTA BARAT propinsi DKI JAKARTA'
        ]);
        PelakuUsaha::create([
            'nama' => 'ALPHA CENTAURI BERJANGKA',
            'alamat' => 'Pakuwon Tower, Lt. 11, Jl. Casablanca Raya, Kav. 88 kelurahan KARET KUNINGAN kecamatan SETIA BUDI kota JAKARTA SELATAN propinsi DKI JAKARTA'
        ]);
        PelakuUsaha::create([
            'nama' => 'GENESIS GEMILANG FUTURES',
            'alamat' => 'Jl. Letjend S Parman Kavling 28 Soho Capital Office Building Lantai 16, Unit 1608-1609, kelurahan TANJUNG DUREN SELATAN kecamatan GROGOL PETAMBURAN, JAKARTA BARAT, DKI JAKARTA'
        ]);
    }
}
