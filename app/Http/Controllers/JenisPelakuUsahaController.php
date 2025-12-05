<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPelakuUsaha;

class JenisPelakuUsahaController extends Controller
{
    public function index()
    {
        return view('jenis_pelaku_usaha.index', [
            'title' => 'List Jenis Pelaku Usaha',
            'jenis_pelaku_usaha' => JenisPelakuUsaha::all()
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
}
