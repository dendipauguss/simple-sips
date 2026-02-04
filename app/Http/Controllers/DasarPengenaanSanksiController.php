<?php

namespace App\Http\Controllers;

use App\Models\DasarPengenaanSanksi;
use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;

class DasarPengenaanSanksiController extends Controller
{
    public function getJenisPelanggaranByDasarPengenaanSanksi($dasar_pengenaan_sanksi_id)
    {
        $jenis_pelanggaran = JenisPelanggaran::where('dasar_pengenaan_sanksi_id', $dasar_pengenaan_sanksi_id)->get();

        return response()->json($jenis_pelanggaran);
    }
}
