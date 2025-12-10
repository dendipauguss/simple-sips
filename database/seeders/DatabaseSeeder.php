<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SanksiSeeder::class,
            // PerintahSanksiSeeder::class,
            JenisPelakuUsahaSeeder::class,
            // PelakuUsahaSeeder::class,
            // PerihalSeeder::class,
            JenisPelanggaranSeeder::class,
            KategoriSPSeeder::class,
            // PengenaanSPSeeder::class
        ]);
    }
}
