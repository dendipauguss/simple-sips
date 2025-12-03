<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perusahaan;

class PerusahaanController extends Controller
{
    public function index()
    {
        return view('perusahaan.index', [
            'title' => 'List Perusahaan',
            'perusahaan' => Perusahaan::all()
        ]);
    }

    public function create()
    {
        return view('perusahaan.create', [
            'title' => 'Tambah Perusahaan Baru'
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama'    => 'required|string|max:255',
            'alamat'  => 'nullable|string'
        ]);

        // Simpan ke database
        Perusahaan::create([
            'nama'    => $request->nama,
            'alamat'  => $request->alamat
        ]);

        // Redirect dengan pesan sukses
        return redirect('perusahaan')->with('success', 'Data perusahaan berhasil disimpan!');
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $title = 'Perusahaan';
        return view('perusahaan.show', compact('perusahaan', 'title'));
    }

    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $title = 'Edit Perusahaan';
        return view('perusahaan.edit', compact('perusahaan', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
        ]);

        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->nama = $request->nama;
        $perusahaan->alamat = $request->alamat;
        $perusahaan->save();

        return redirect()->route('perusahaan.index')->with('success', 'Data perusahaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();

        return redirect()->route('perusahaan.index')->with('success', 'Data perusahaan berhasil dihapus!');
    }
}
