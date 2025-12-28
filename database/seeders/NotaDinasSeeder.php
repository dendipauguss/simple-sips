<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\NotaDinas;

class NotaDinasSeeder extends Seeder
{
    public function run(): void
    {
        NotaDinas::create([
            'no_nota_dinas' => 'UD.01.00/001/BAPPEBTI.3/ND/1/2025',
            'tanggal_nota_dinas' => Carbon::create(2025, 1, 02)->toDateTimeString(),
            'dasar_pengenaan_sanksi_id' => 1
        ]);
        NotaDinas::create([
            'no_nota_dinas' => 'UD.01.00/002/BAPPEBTI.3/ND/1/2025',
            'tanggal_nota_dinas' => Carbon::create(2025, 1, 12)->toDateTimeString(),
            'dasar_pengenaan_sanksi_id' => 1
        ]);
        NotaDinas::create([
            'no_nota_dinas' => 'UD.01.00/003/BAPPEBTI.3/ND/1/2025',
            'tanggal_nota_dinas' => Carbon::create(2025, 1, 22)->toDateTimeString(),
            'dasar_pengenaan_sanksi_id' => 1
        ]);
        NotaDinas::create([
            'no_nota_dinas' => 'UD.01.00/004/BAPPEBTI.3/ND/2/2025',
            'tanggal_nota_dinas' => Carbon::create(2025, 2, 01)->toDateTimeString(),
            'dasar_pengenaan_sanksi_id' => 1
        ]);
        NotaDinas::create([
            'no_nota_dinas' => 'UD.01.00/005/BAPPEBTI.3/ND/2/2025',
            'tanggal_nota_dinas' => Carbon::create(2025, 2, 11)->toDateTimeString(),
            'dasar_pengenaan_sanksi_id' => 1
        ]);
    }
}
