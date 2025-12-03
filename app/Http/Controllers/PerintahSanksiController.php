<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerintahSanksi;

class PerintahSanksiController extends Controller
{
    public function index()
    {
        return view('sanksi_perintah.index', [
            'title' => 'Perintah Bentuk Sanksi',
            'perintah_sanksi' => PerintahSanksi::all()
        ]);
    }

    public function show($id)
    {
        $perintah_sanksi = PerintahSanksi::findOrFail($id);
        return view('sanksi_perintah.show', compact('perintah_sanksi'));
    }
}
