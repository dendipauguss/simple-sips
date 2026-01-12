<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriSP;
use App\Models\JenisPelanggaran;
use App\Imports\KategoriSPImport;
use Maatwebsite\Excel\Facades\Excel;

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
            'title' => 'List Kategori Sanksi',
            'kategori_sp' => $kategori_sp,
            'jenis_pelanggaran' => JenisPelanggaran::all()
        ]);
    }

    public function create()
    {
        return view('kategori_sp.create', [
            'title' => 'Tambah Kategori Sanksi Baru',
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
        return redirect('pengaturan/kategori-sp')->with('success', 'Data Kategori Sanksi berhasil disimpan!');
    }

    public function show($id)
    {
        $kategori_sp = KategoriSP::findOrFail($id);
        $title = 'Detail Kategori Sanksi';
        return view('kategori_sp.show', compact('kategori_sp', 'title'));
    }

    public function edit($id)
    {
        $kategori_sp = KategoriSP::findOrFail($id);
        $jenis_pelanggaran = JenisPelanggaran::all();
        $title = 'Edit Kategori Sanksi';
        return view('kategori_sp.create', compact('kategori_sp', 'jenis_pelanggaran', 'title'));
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

        return redirect()->route('kategori-sp.index')->with('success', 'Data Kategori Sanksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori_sp = KategoriSP::findOrFail($id);
        $kategori_sp->delete();

        return redirect()->route('kategori-sp.index')->with('success', 'Data Kategori Sanksi berhasil dihapus!');
    }

    public function importView()
    {
        return view('kategori_sp.import', [
            'title' => 'Import Excel Kategori Sanksi',
            'jenis_pelanggaran' => JenisPelanggaran::all()
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new KategoriSPImport, $request->file('file'));

        return back()->with('success', 'Data Kategori Sanksi berhasil diimport!');
    }

    public function getPelakuUsahaByJenis($jenis_pelanggaran_id)
    {
        $kategori_sp = KategoriSP::where('jenis_pelanggaran_id', $jenis_pelanggaran_id)->get();

        return response()->json($kategori_sp);
    }
}
