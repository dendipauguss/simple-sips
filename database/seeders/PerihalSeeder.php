<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Perihal;

class PerihalSeeder extends Seeder
{
    public function run(): void
    {
        Perihal::create([
            'nama' => 'Perihal 1'
        ]);

        Perihal::create([
            'nama' => 'Perihal 2'
        ]);

        Perihal::create([
            'nama' => 'Perihal 3'
        ]);

        Perihal::create([
            'nama' => 'Perihal 4'
        ]);

        Perihal::create([
            'nama' => 'Perihal 5'
        ]);
    }
}
