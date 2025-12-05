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
        if ($request->jenis_pelaku_usaha) {
            $pelaku_usaha = PelakuUsaha::where('jenis_id', $request->jenis_pelaku_usaha)->get();
        } else {
            $pelaku_usaha = PelakuUsaha::all();
        }

        return view('pelaku_usaha.index', [
            'title' => 'List Pelaku Usaha',
            'pelaku_usaha' => $pelaku_usaha,
            'jenis_pelaku_usaha' => JenisPelakuUsaha::all()
        ]);
    }

    public function create()
    {
        return view('pelaku_usaha.create', [
            'title' => 'Tambah Pelaku Usaha Baru',
            'jenis_pelaku_usaha' => JenisPelakuUsaha::all()
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
        return redirect('pelaku_usaha')->with('success', 'Data Pelaku Usaha berhasil disimpan!');
    }

    public function show($id)
    {
        $pelaku_usaha = PelakuUsaha::findOrFail($id);
        $title = 'Detail Pelaku Usaha';
        return view('pelaku_usaha.show', compact('pelaku_usaha', 'title'));
    }

    public function edit($id)
    {
        $pelaku_usaha = PelakuUsaha::findOrFail($id);
        $jenis_pelaku_usaha = JenisPelakuUsaha::all();
        $title = 'Edit Pelaku Usaha';
        return view('pelaku_usaha.edit', compact('pelaku_usaha', 'jenis_pelaku_usaha', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jenis_id' => 'required',
        ]);

        $pelaku_usaha = PelakuUsaha::findOrFail($id);
        $pelaku_usaha->nama = $request->nama;
        $pelaku_usaha->jenis_id = $request->jenis_id;
        $pelaku_usaha->save();

        return redirect()->route('pelaku-usaha.index')->with('success', 'Data Pelaku Usaha berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pelaku_usaha = PelakuUsaha::findOrFail($id);
        $pelaku_usaha->delete();

        return redirect()->route('pelaku-usaha.index')->with('success', 'Data Pelaku Usaha berhasil dihapus!');
    }

    public function importView()
    {
        return view('pelaku_usaha.import', [
            'title' => 'Import Excel',
            'jenis_pelaku_usaha' => JenisPelakuUsaha::all()
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new PelakuUsahaImport, $request->file('file'));

        return back()->with('success', 'Data Pelaku Usaha berhasil diimport!');
    }

    public function getpelaku_usahaByJenis($jenis_id)
    {
        $pelaku_usaha = PelakuUsaha::where('jenis_id', $jenis_id)->get();

        return response()->json($pelaku_usaha);
    }
}
