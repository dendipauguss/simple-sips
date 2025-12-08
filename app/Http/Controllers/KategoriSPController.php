<?php

namespace App\Http\Controllers;

use App\Models\KategoriSP;
use Illuminate\Http\Request;

class KategoriSPController extends Controller
{
    public function index()
    {
        return view('kategori_sp.index', [
            'title' => 'Kategori SP',
            'kategori_sp' => KategoriSP::all()
        ]);
    }

    public function create() {}

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
}
