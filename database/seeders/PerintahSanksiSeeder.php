<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerintahSanksi;

class PerintahSanksiSeeder extends Seeder
{
    public function run()
    {
        PerintahSanksi::create([
            'nama' => 'Melaksanakan ....',
            'sanksi_id' => 1
        ]);

        PerintahSanksi::create([
            'nama' => 'Menyelenggarakan ....',
            'sanksi_id' => 1
        ]);
    }
}
