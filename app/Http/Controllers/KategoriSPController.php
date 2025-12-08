<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriSP;
use App\Models\JenisPelanggaran;

class KategoriSPController extends Controller
{
    public function index(Request $request)
    {
        if ($request->jenis_pelanggaran) {
            $kategori_sp = KategoriSP::where('jenis_pelanggaran_id', $request->jenis_pelanggaran)->latest()->get();
        } else {
            $kategori_sp = KategoriSP::latest()->get();
        }

        return view('kategori_sp.index', [
            'title' => 'List Pelaku Usaha',
            'kategori_sp' => $kategori_sp,
            'jenis_pelanggaran' => JenisPelanggaran::all()
        ]);
    }

    public function create()
    {
        return view('kategori_sp.create', [
            'title' => 'Tambah Pelaku Usaha Baru',
            'jenis_pelanggaran' => JenisPelanggaran::all()
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama'    => 'required|string|max:255',
            'jenis_pelanggaran_id'  => 'required'
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.max' => 'Maksimal 255 karakter',
        ]);

        // Simpan ke database
        KategoriSP::create([
            'nama'    => $request->nama,
            'jenis_pelanggaran_id'  => $request->jenis_pelanggaran_id
        ]);

        // Redirect dengan pesan sukses
        return redirect('pengaturan/pelaku-usaha')->with('success', 'Data Pelaku Usaha berhasil disimpan!');
    }

    public function show($id)
    {
        $kategori_sp = KategoriSP::findOrFail($id);
        $title = 'Detail Pelaku Usaha';
        return view('kategori_sp.show', compact('kategori_sp', 'title'));
    }

    public function edit($id)
    {
        $kategori_sp = KategoriSP::findOrFail($id);
        $jenis_pelanggaran = JenisPelanggaran::all();
        $title = 'Edit Pelaku Usaha';
        return view('kategori_sp.edit', compact('kategori_sp', 'jenis_pelanggaran', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'jenis_pelanggaran_id' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.max' => 'Maksimal 255 karakter',
        ]);

        $kategori_sp = KategoriSP::findOrFail($id);
        $kategori_sp->nama = $request->nama;
        $kategori_sp->jenis_pelanggaran_id = $request->jenis_pelanggaran_id;
        $kategori_sp->save();

        return redirect()->route('pelaku-usaha.index')->with('success', 'Data Pelaku Usaha berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori_sp = KategoriSP::findOrFail($id);
        $kategori_sp->delete();

        return redirect()->route('pelaku-usaha.index')->with('success', 'Data Pelaku Usaha berhasil dihapus!');
    }

    public function importView()
    {
        return view('kategori_sp.import', [
            'title' => 'Import Excel',
            'jenis_pelanggaran' => JenisPelanggaran::all()
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

    public function getPelakuUsahaByJenis($jenis_pelanggaran_id)
    {
        $kategori_sp = KategoriSP::where('jenis_pelanggaran_id', $jenis_pelanggaran_id)->get();

        return response()->json($kategori_sp);
    }
}
