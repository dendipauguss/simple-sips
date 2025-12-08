<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengenaanSP;
use App\Models\PelakuUsaha;
use App\Models\JenisPelakuUsaha;
use App\Models\JenisPelanggaran;
use App\Models\KategoriSP;
use App\Models\Files;
use PDF;
use Illuminate\Support\Facades\Storage;

class PengenaanSPController extends Controller
{
    public function index()
    {
        return view('pengenaan_sp.index', [
            'title' => 'Pengenaan SP',
            'pengenaan_sp' => PengenaanSP::latest()->get()
        ]);
    }

    public function create()
    {
        $title = 'Buat SP';
        $pelaku_usaha = PelakuUsaha::all();
        $jenis_pelaku_usaha = JenisPelakuUsaha::all();
        $jenis_pelanggaran = JenisPelanggaran::all();
        $kategori_sp = KategoriSP::all();
        // ambil nomor terakhir
        $last = PengenaanSP::orderBy('id', 'DESC')->first();

        // generate nomor baru (3 digit)
        $nextNumber = $last ? str_pad($last->id + 1, 3, '0', STR_PAD_LEFT) : '001';

        // template nomor SP awal (belum ada bulan & tahun)
        $no_sp_template = "UD.02.01/{$nextNumber}/BAPPEBTI/SP/";

        return view('pengenaan_sp.create', compact('no_sp_template', 'pelaku_usaha', 'jenis_pelanggaran', 'kategori_sp', 'jenis_pelaku_usaha', 'title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'pelaku_usaha_id' => 'required',
            'jenis_pelanggaran_id' => 'required',
            'kategori_sp_id' => 'required',
            'detail_pelanggaran' => 'nullable',
        ]);

        // ---- 1. Generate no_sp awal ----
        $last = PengenaanSp::orderBy('id', 'DESC')->first();
        $urutan = $last ? sprintf('%03d', $last->id + 1) : '001';

        $no_sp = "UD.02.01/{$urutan}/BAPPEBTI/SP/";

        // ---- 2. Simpan data awal ----
        $sp = PengenaanSp::create([
            'no_sp' => $no_sp,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'pelaku_usaha_id' => $request->pelaku_usaha_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'kategori_sp_id' => $request->kategori_sp_id,
            'detail_pelanggaran' => $request->detail_pelanggaran,
            'user_id' => auth()->id(),
        ]);

        // ---- 3. Update no_sp dengan bulan/tahun ----
        $bulan = \Carbon\Carbon::parse($sp->tanggal_mulai)->format('m');
        $tahun = \Carbon\Carbon::parse($sp->tanggal_mulai)->format('Y');

        $sp->update([
            'no_sp' => $sp->no_sp . "{$bulan}/{$tahun}"
        ]);

        // ---- 4. Otomatis Export PDF setelah simpan ----
        $this->exportPdf($sp->id);

        return redirect()->route('pengenaan-sp.index')
            ->with('success', 'Data berhasil disimpan dan PDF otomatis dibuat.');
    }

    public function show($id)
    {
        return view('pengenaan_sp.show', [
            'title' => 'Detail SP',
            'sp' => PengenaanSP::findOrFail($id)
        ]);
    }

    public function edit(PengenaanSP $pengenaanSP)
    {
        //
    }

    public function update(Request $request, PengenaanSP $pengenaanSP)
    {
        //
    }

    public function destroy(PengenaanSP $pengenaanSP)
    {
        //
    }

    public function exportPdf($id)
    {
        $sp = PengenaanSP::with(['pelaku_usaha', 'jenis_pelanggaran', 'kategori_sp'])
            ->findOrFail($id);

        $filename = 'SP-' . str_replace('/', '-', $sp->no_sp) . '.pdf';
        $path = 'pengenaan_sp/' . $filename;

        $pdf = PDF::loadView('pengenaan_sp.pdf', compact('sp'))
            ->setPaper('A4', 'portrait');

        // Simpan file ke disk
        Storage::disk('public')->put($path, $pdf->output());

        // Simpan metadata ke table files
        Files::create([
            'table_id'      => $sp->id,
            'table_name'    => 'pengenaan_sp',
            'filename'      => $filename,
            'original_name' => $filename,
            'url_path'      => 'storage/' . $path,
            'status'        => 1,
        ]);
    }
}
