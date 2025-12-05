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
            // PerusahaanSeeder::class,
            // SanksiSeeder::class,
            // PerintahSanksiSeeder::class,
            // JenisPerusahaanSeeder::class,
            // PerihalSeeder::class
        ]);
    }
}
