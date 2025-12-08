<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriSP;
use App\Models\JenisPelanggaran;

class JenisPelanggaranController extends Controller
{
    public function index()
    {
        return view('jenis_pelanggaran', [
            'title' => 'Jenis Pelanggaran',
            'jenis_pelanggaran' => JenisPelanggaran::all()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function getKategoriSPByJenis($jenis_pelanggaran_id)
    {
        $kategori_sp = KategoriSP::where('jenis_pelanggaran_id', $jenis_pelanggaran_id)->get();

        return response()->json($kategori_sp);
    }
}
