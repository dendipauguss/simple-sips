<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Laporan;
use App\Models\LaporanItem;
use App\Models\PengenaanSP;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'title' => 'Data Laporan Pengenaan Sanksi',
            'laporan' => Laporan::orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get()
        ]);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required'
        ]);

        // Cek apakah laporan bulan-tahun ini sudah ada
        if (Laporan::where('bulan', $request->bulan)->where('tahun', $request->tahun)->exists()) {
            return back()->with('error', 'Laporan bulan tersebut sudah ada.');
        }

        // Buat laporan baru
        $laporan = Laporan::create([
            'bulan' => $request->bulan,
            'tahun' => $request->tahun
        ]);

        // Ambil data pengenaan_sp berdasarkan bulan–tahun
        $data = PengenaanSP::whereMonth('tanggal_mulai', $request->bulan)
            ->whereYear('tanggal_mulai', $request->tahun)
            ->get();

        // Masukkan ke pivot
        foreach ($data as $sp) {
            LaporanItem::create([
                'laporan_id' => $laporan->id,
                'pengenaan_sp_id' => $sp->id
            ]);
        }

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dibuat.');
    }

    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);

        $items = $laporan->pengenaan_sp()
            ->with('pelaku_usaha.jenis_pelaku_usaha')
            ->get()
            ->groupBy('pelaku_usaha.jenis_pelaku_usaha.nama');

        return view('laporan.show', [
            'title' => 'Detail Laporan',
            'items' => $items,
            'laporan' => $laporan
        ]);
    }

    public function pdf($id)
    {
        $laporan = Laporan::findOrFail($id);

        $items = $laporan->pengenaan_sp
            ->load(['pelaku_usaha.jenis_pelaku_usaha', 'sanksi', 'jenis_pelanggaran'])
            ->groupBy([
                fn($item) => $item->pelaku_usaha->jenis_pelaku_usaha->nama,
                fn($item) => $item->pelaku_usaha->nama,
                fn($item) => $item->sanksi->nama,
            ]);


        $pdf = PDF::loadView('laporan.pdf', compact('laporan', 'items'));
        return $pdf->stream("laporan-{$laporan->bulan}-{$laporan->tahun}.pdf");
    }

    public function approve($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status_disetujui' => !$laporan->status_disetujui
        ]);

        return back()->with('success', 'Status laporan diperbarui.');
    }

    public function isiCatatan(Request $request, $id)
    {
        $request->validate([
            'catatan' => ['required', 'string', 'max:100']
        ], [
            'catatan.required' => 'Tidak boleh kosong kakak',
            'catatan.max' => 'Maksimal 100 karakter kakak'
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'catatan' => $request->catatan
        ]);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dibuat.');
    }
}
