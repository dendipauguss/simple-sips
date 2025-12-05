<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerintahSanksi;
use App\Models\Sanksi;

class PerintahSanksiController extends Controller
{
    public function index()
    {
        return view('sanksi_perintah.index', [
            'title' => 'Perintah Bentuk Sanksi',
            'perintah_sanksi' => PerintahSanksi::all()
        ]);
    }

    public function create()
    {
        return view('sanksi_perintah.create', [
            'title' => 'Buat Bentuk Sanksi Baru',
            'sanksi' => Sanksi::all()
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        // Validasi input
        $request->validate([
            'nama'    => 'required|string|max:255',
            'sanksi_id' => 'required|integer'
        ]);

        // Simpan ke database
        PerintahSanksi::create([
            'nama'    => $request->nama,
            'sanksi_id' => $request->sanksi_id
        ]);

        // Redirect dengan pesan sukses
        return redirect('pengaturan/perintah-sanksi')->with('success', 'Data berhasil disimpan!');
    }

    public function show($id)
    {
        $perintah_sanksi = PerintahSanksi::findOrFail($id);
        return view('sanksi_perintah.show', compact('perintah_sanksi'));
    }

    public function edit($id)
    {
        $perintah_sanksi = PerintahSanksi::findOrFail($id);
        $title = 'Edit Bentuk Sanksi';
        return view('sanksi_perintah.edit', compact('perintah_sanksi', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $perintah_sanksi = PerintahSanksi::findOrFail($id);
        $perintah_sanksi->nama = $request->nama;
        $perintah_sanksi->sanksi_id = $request->sanksi_id;
        $perintah_sanksi->save();

        return redirect()->route('sanksi_perintah.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $sanksi = PerintahSanksi::findOrFail($id);
        $sanksi->delete();

        return redirect()->route('sanksi_perintah.index')->with('success', 'Data berhasil dihapus!');
    }
}
