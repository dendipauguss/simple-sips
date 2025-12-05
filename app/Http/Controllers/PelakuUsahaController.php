<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PelakuUsaha;
use App\Imports\PelakuUsahaImport;
use App\Models\JenisPelakuUsaha;
use Maatwebsite\Excel\Facades\Excel;

class PelakuUsahaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->jenis_perusahaan) {
            $perusahaan = PelakuUsaha::where('jenis_id', $request->jenis_perusahaan)->get();
        } else {
            $perusahaan = PelakuUsaha::all();
        }

        return view('perusahaan.index', [
            'title' => 'List Perusahaan',
            'perusahaan' => $perusahaan,
            'jenis_perusahaan' => JenisPelakuUsaha::all()
        ]);
    }

    public function create()
    {
        return view('perusahaan.create', [
            'title' => 'Tambah Perusahaan Baru',
            'jenis_perusahaan' => JenisPelakuUsaha::all()
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
        PelakuUsaha::create([
            'nama'    => $request->nama,
            'alamat'  => $request->alamat
        ]);

        // Redirect dengan pesan sukses
        return redirect('perusahaan')->with('success', 'Data perusahaan berhasil disimpan!');
    }

    public function show($id)
    {
        $perusahaan = PelakuUsaha::findOrFail($id);
        $title = 'Perusahaan';
        return view('perusahaan.show', compact('perusahaan', 'title'));
    }

    public function edit($id)
    {
        $perusahaan = PelakuUsaha::findOrFail($id);
        $title = 'Edit Perusahaan';
        return view('perusahaan.edit', compact('perusahaan', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
        ]);

        $perusahaan = PelakuUsaha::findOrFail($id);
        $perusahaan->nama = $request->nama;
        $perusahaan->alamat = $request->alamat;
        $perusahaan->save();

        return redirect()->route('perusahaan.index')->with('success', 'Data perusahaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $perusahaan = PelakuUsaha::findOrFail($id);
        $perusahaan->delete();

        return redirect()->route('perusahaan.index')->with('success', 'Data perusahaan berhasil dihapus!');
    }

    public function importView()
    {
        return view('perusahaan.import', [
            'title' => 'Import Excel'
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new PelakuUsahaImport, $request->file('file'));

        return back()->with('success', 'Data perusahaan berhasil diimport!');
    }

    public function getPerusahaanByJenis($jenis_id)
    {
        $perusahaan = PelakuUsaha::where('jenis_id', $jenis_id)->get();

        return response()->json($perusahaan);
    }
}
