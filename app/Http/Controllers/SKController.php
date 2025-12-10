<?php

namespace App\Http\Controllers;

use App\Models\SK;
use App\Models\PengenaanSP;
use Illuminate\Http\Request;

class SKController extends Controller
{
    public function index()
    {
        //
    }

    public function create($pengenaan_sp_id = null)
    {
        // ambil nomor terakhir
        $last = SK::orderBy('id', 'DESC')->first();
        // generate nomor baru (3 digit)
        $nextNumber = $last ? str_pad($last->id + 1, 3, '0', STR_PAD_LEFT) : '001';

        $pengenaan_sp = PengenaanSP::findOrFail($pengenaan_sp_id);

        return view('sk.create', [
            'title' => 'SK',
            'pengenaan_sp' => $pengenaan_sp,
            'no_surat_template' => "UD.02.01/{$nextNumber}/BAPPEBTI/"
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(SK $sK)
    {
        //
    }

    public function edit(SK $sK)
    {
        //
    }

    public function update(Request $request, SK $sK)
    {
        //
    }

    public function destroy(SK $sK)
    {
        //
    }
}
