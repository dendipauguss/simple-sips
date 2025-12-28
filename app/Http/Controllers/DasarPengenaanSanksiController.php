<?php

namespace App\Http\Controllers;

use App\Models\DasarPengenaanSanksi;
use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;

class DasarPengenaanSanksiController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(DasarPengenaanSanksi $dasarPengenaanSanksi)
    {
        //
    }

    public function edit(DasarPengenaanSanksi $dasarPengenaanSanksi)
    {
        //
    }

    public function update(Request $request, DasarPengenaanSanksi $dasarPengenaanSanksi)
    {
        //
    }

    public function destroy(DasarPengenaanSanksi $dasarPengenaanSanksi)
    {
        //
    }

    public function getJenisPelanggaranByDasarPengenaanSanksi($dasar_pengenaan_sanksi_id)
    {
        $jenis_pelanggaran = JenisPelanggaran::where('dasar_pengenaan_sanksi_id', $dasar_pengenaan_sanksi_id)->get();

        return response()->json($jenis_pelanggaran);
    }
}
