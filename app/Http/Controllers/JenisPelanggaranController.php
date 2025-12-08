<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriSP;
use App\Models\JenisPelanggaran;

class JenisPelanggaranController extends Controller
{
    public function index()
    {
        return view('jenis_pelanggaran.index', [
            'title' => 'Jenis Pelanggaran',
            'jenis_pelanggaran' => JenisPelanggaran::all()
        ]);
    }

    public function create()
    {
        return view('jenis_pelanggaran.create', [
            'title' => 'Tambah Jenis Pelanggaran Baru'
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'nama.*'    => ['required', 'string', 'max:255']
        ], [
            'nama.*.required' => 'Kolom nama ke-:number wajib diisi!'
        ]);
        $data = [];

        foreach ($request->nama as $nama) {
            $data[] = [
                'nama' => $nama
            ];
        }

        JenisPelanggaran::insert($data);

        // Redirect dengan pesan sukses
        return redirect('pengaturan/jenis-pelanggaran')->with('success', 'Data Jenis Pelanggaran berhasil disimpan!');
    }

    public function show(string $id)
    {
        $jenis_pelanggaran = JenisPelanggaran::findOrFail($id);
        $title = 'Detail Jenis Pelanggaran';
        return view('jenis_pelanggaran.show', compact('jenis_pelanggaran', 'title'));
    }

    public function edit(string $id)
    {
        $jenis_pelanggaran = JenisPelanggaran::findOrFail($id);
        $title = 'Edit Jenis Pelanggaran';
        return view('jenis_pelanggaran.edit', compact('jenis_pelanggaran', 'title'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $jenis_pelanggaran = JenisPelanggaran::findOrFail($id);
        $jenis_pelanggaran->nama = $request->nama;
        $jenis_pelanggaran->save();

        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Data Jenis Pelanggaran berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $jenis_pelanggaran = JenisPelanggaran::findOrFail($id);
        $jenis_pelanggaran->delete();

        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Data Pelaku Usaha berhasil dihapus!');
    }

    public function getKategoriSPByJenis($jenis_pelanggaran_id)
    {
        $kategori_sp = KategoriSP::where('jenis_pelanggaran_id', $jenis_pelanggaran_id)->get();

        return response()->json($kategori_sp);
    }
}
