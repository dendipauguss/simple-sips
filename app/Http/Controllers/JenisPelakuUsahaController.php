<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPelakuUsaha;

class JenisPelakuUsahaController extends Controller
{
    public function index()
    {
        return view('jenis_pelaku_usaha.index', [
            'title' => 'List Jenis Pelaku Usaha',
            'jenis_pelaku_usaha' => JenisPelakuUsaha::all()
        ]);
    }

    public function create()
    {
        return view('jenis_pelaku_usaha.create', [
            'title' => 'Tambah Jenis Pelaku Usaha Baru'
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

        JenisPelakuUsaha::insert($data);

        // Redirect dengan pesan sukses
        return redirect('jenis-pelaku-usaha')->with('success', 'Data Jenis Pelaku Usaha berhasil disimpan!');
    }

    public function show(string $id)
    {
        $jenis_pelaku_usaha = JenisPelakuUsaha::findOrFail($id);
        $title = 'Detail Jenis Pelaku Usaha';
        return view('jenis_pelaku_usaha.show', compact('jenis_pelaku_usaha', 'title'));
    }

    public function edit(string $id)
    {
        $jenis_pelaku_usaha = JenisPelakuUsaha::findOrFail($id);
        $title = 'Edit Jenis Pelaku Usaha';
        return view('jenis_pelaku_usaha.edit', compact('jenis_pelaku_usaha', 'title'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $jenis_pelaku_usaha = JenisPelakuUsaha::findOrFail($id);
        $jenis_pelaku_usaha->nama = $request->nama;
        $jenis_pelaku_usaha->save();

        return redirect()->route('jenis-pelaku-usaha.index')->with('success', 'Data Jenis Pelaku Usaha berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $jenis_pelaku_usaha = JenisPelakuUsaha::findOrFail($id);
        $jenis_pelaku_usaha->delete();

        return redirect()->route('jenis-pelaku-usaha.index')->with('success', 'Data Pelaku Usaha berhasil dihapus!');
    }
}
