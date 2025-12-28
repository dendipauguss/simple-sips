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
            $pelaku_usaha = PelakuUsaha::where('jenis_id', $request->jenis_pelaku_usaha)->latest()->get();
        } else {
            $pelaku_usaha = PelakuUsaha::latest()->get();
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
            'jenis_id'  => 'required'
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.max' => 'Maksimal 255 karakter',
        ]);

        // Simpan ke database
        PelakuUsaha::create([
            'nama'    => $request->nama,
            'jenis_id'  => $request->jenis_id
        ]);

        // Redirect dengan pesan sukses
        return redirect('pengaturan/pelaku-usaha')->with('success', 'Data Pelaku Usaha berhasil disimpan!');
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
            'nama' => 'required|max:255',
            'jenis_id' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.max' => 'Maksimal 255 karakter',
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
            'title' => 'Import Excel Perusahaan',
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

    public function getPelakuUsahaByJenis($jenis_id)
    {
        $pelaku_usaha = PelakuUsaha::where('jenis_id', $jenis_id)->get();

        return response()->json($pelaku_usaha);
    }
}
