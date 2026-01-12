<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sanksi;

class SanksiController extends Controller
{
    public function index()
    {
        return view('sanksi.index', [
            'title' => 'Sanksi',
            'sanksi' => Sanksi::all()
        ]);
    }

    public function create()
    {
        return view('sanksi.create', [
            'title' => 'Buat Bentuk Sanksi Baru'
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama'    => ['required', 'string', 'max:255'],
            'kode_surat' => ['required', 'unique:sanksi']
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'nama.max' => 'Maksimal 255 karakter',
            'kode_surat.unique' => 'Kode sudah dipakai',
            'kode_surat.required' => 'Kode Surat tidak boleh kosong kakak'
        ]);

        // Simpan ke database
        Sanksi::create([
            'nama'    => $request->nama,
            'kode_surat' => $request->kode_surat
        ]);

        // Redirect dengan pesan sukses
        return redirect('pengaturan/sanksi')->with('success', 'Data berhasil disimpan!');
    }

    public function show($id)
    {
        $sanksi = Sanksi::findOrFail($id);
        $title = 'Detail Sanksi';
        return view('sanksi.show', compact('sanksi', 'title'));
    }

    public function edit($id)
    {
        $sanksi = Sanksi::findOrFail($id);
        $title = 'Edit Bentuk Sanksi';
        return view('sanksi.edit', compact('sanksi', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'kode_surat' => 'required'
        ], [
            'nama.required' => 'Tidak boleh kosong kakak',
            'kode_surat.required' => 'Tidak boleh kosong kakak'
        ]);

        $sanksi = Sanksi::findOrFail($id);
        $sanksi->nama = $request->nama;
        $sanksi->kode_surat = $request->kode_surat;
        $sanksi->save();

        return redirect()->route('sanksi.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $sanksi = Sanksi::findOrFail($id);
        $sanksi->delete();

        return redirect()->route('sanksi.index')->with('success', 'Data berhasil dihapus!');
    }
}
