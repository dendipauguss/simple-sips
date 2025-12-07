<?php

namespace App\Http\Controllers;

use App\Models\PengenaanSP;
use Illuminate\Http\Request;

class PengenaanSPController extends Controller
{
    public function index()
    {
        return view('pengenaan_sp.index', [
            'title' => 'Pengenaan SP',
            'pengenaan_sp' => PengenaanSP::latest()->get()
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

    public function show(PengenaanSP $pengenaanSP)
    {
        //
    }

    public function edit(PengenaanSP $pengenaanSP)
    {
        //
    }

    public function update(Request $request, PengenaanSP $pengenaanSP)
    {
        //
    }

    public function destroy(PengenaanSP $pengenaanSP)
    {
        //
    }
}
