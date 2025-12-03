<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sanksi;

class SanksiSeeder extends Seeder
{
    public function run()
    {
        Sanksi::create([
            'nama' => 'Surat Peringatan',
        ]);
    }
}
