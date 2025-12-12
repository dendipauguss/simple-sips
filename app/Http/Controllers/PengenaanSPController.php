<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PengenaanSPExport;
use App\Models\PengenaanSP;
use App\Models\PelakuUsaha;
use App\Models\JenisPelakuUsaha;
use App\Models\JenisPelanggaran;
use App\Models\KategoriSP;
use App\Models\Files;
use App\Models\Sanksi;
use App\Models\Laporan;
use App\Models\LaporanItem;

class PengenaanSPController extends Controller
{
    public function index(Request $request)
    {
        $query = PengenaanSP::query();

        $bulanList = PengenaanSP::selectRaw('MONTH(tanggal_mulai) as bulan')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('bulan');

        $tahunList = PengenaanSP::selectRaw('YEAR(tanggal_mulai) as tahun')
            ->groupBy('tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $pengenaan_sp = $query
            ->orderByRaw('ABS(DATEDIFF(tanggal_selesai, CURDATE())) ASC')
            ->get();

        return view('pengenaan_sp.index', [
            'title' => 'Pengenaan Sanksi',
            'pengenaan_sp' => $pengenaan_sp,
            'bulanList' => $bulanList,
            'tahunList' => $tahunList
        ]);
    }

    public function create()
    {
        // ambil nomor terakhir
        $last = PengenaanSP::orderBy('id', 'DESC')->first();
        // generate nomor baru (3 digit)
        $nextNumber = $last ? str_pad($last->id + 1, 3, '0', STR_PAD_LEFT) : '001';

        return view('pengenaan_sp.create', [
            'title' => 'Buat Sanksi',
            'pelaku_usaha' => PelakuUsaha::all(),
            'jenis_pelaku_usaha' => JenisPelakuUsaha::all(),
            'jenis_pelanggaran' => JenisPelanggaran::all(),
            'kategori_sp' => KategoriSP::all(),
            'sanksi' => Sanksi::all(),
            // template nomor SP awal (belum ada bulan & tahun)
            'no_surat_template' => "UD.02.01/{$nextNumber}/BAPPEBTI/",
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'sanksi_id' => 'required',
            'jenis_pelaku_usaha_id' => 'required',
            'pelaku_usaha_id' => 'required',
            'jenis_pelanggaran_id' => 'required',
            'kategori_sp_id' => 'required',
            'detail_pelanggaran' => 'nullable',
        ]);

        // ---- 1. Generate no_sp awal ----
        $last = PengenaanSP::orderBy('id', 'DESC')->first();
        $urutan = $last ? sprintf('%03d', $last->id + 1) : '001';
        $kode_sanksi = Sanksi::where('id', $request->sanksi_id)->value('kode_surat');
        $no_surat = "{$request->no_surat}/{$urutan}/BAPPEBTI/{$kode_sanksi}";

        // ---- 2. Simpan data awal ----
        $sp = PengenaanSP::create([
            'no_surat' => $no_surat,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'sanksi_id' => $request->sanksi_id,
            'jenis_pelaku_usaha_id' => $request->jenis_pelaku_usaha_id,
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
            'no_surat' => $sp->no_surat . "/{$bulan}/{$tahun}"
        ]);

        // ---- 4. Otomatis Export PDF setelah simpan ----
        // $this->exportPdf($sp->id);
        $this->uploadFile($request, 'pengenaan_sp', $sp->id, 'surat');

        return redirect()->route('pengenaan-sp.show', $sp->id)
            ->with('success', 'Data berhasil disimpan dan PDF otomatis dibuat.');
    }

    public function show($id)
    {
        return view('pengenaan_sp.show', [
            'title' => 'Detail Sanksi',
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

    public function generatePdf($id)
    {
        $sp = PengenaanSP::with(['pelaku_usaha', 'jenis_pelanggaran', 'kategori_sp', 'sanksi'])
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
            'tipe'          => 'surat',
            'filename'      => $filename,
            'original_name' => $filename,
            'url_path'      => 'storage/' . $path,
            'status'        => 1,
        ]);
    }

    public function uploadDokumen(Request $request)
    {
        // dd($request);
        $request->validate([
            'pengenaan_sp_id' => 'required|exists:pengenaan_sp,id',
            'tanggapan' => 'required|string',
            'lampiran.*'    => 'nullable|file|max:5120', // 5 MB
        ]);

        // Panggil fungsi upload file yang sudah kamu buat sebelumnya
        $this->uploadFile($request, 'pengenaan_sp', $request->pengenaan_sp_id, 'bebas');
        $pengenaan_sp = PengenaanSP::findOrFail($request->pengenaan_sp_id);
        $pengenaan_sp->tanggapan = $request->tanggapan;
        $pengenaan_sp->status_surat = 'sudah_ditanggapi';
        $pengenaan_sp->save();

        return back()->with('success', 'Bukti pendukung berhasil diupload.');
    }

    private function uploadFile(Request $request, $table_name, $table_id, $tipe_dokumen)
    {
        $files = $request->file('lampiran');

        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('uploads/' . $table_name, $filename, 'public');

            Files::create([
                'table_name'    => $table_name,
                'table_id'      => $table_id,
                'tipe'          => $tipe_dokumen,
                'filename'      => $filename,
                'original_name' => $originalName,
                'url_path'      => 'storage/' . $path, // ← perbaikan
            ]);
        }
    }

    public function laporan(Request $request)
    {
        $query = PengenaanSP::query();

        // === Filter Bulan ===
        if ($request->bulan) {
            $query->whereMonth('tanggal_mulai', $request->bulan);
        } else {
            // === Filter Periode Tanggal ===
            if ($request->start && $request->end) {
                $query->whereBetween('tanggal_mulai', [$request->start, $request->end]);
            } elseif ($request->start) {
                $query->whereDate('tanggal_mulai', '>=', $request->start);
            } elseif ($request->end) {
                $query->whereDate('tanggal_mulai', '<=', $request->end);
            }
        }

        $pengenaan_sp = $query
            ->orderByRaw('ABS(DATEDIFF(tanggal_selesai, CURDATE())) ASC')
            ->get();

        $pengenaan_sp_grouped = $pengenaan_sp->groupBy(function ($item) {
            return $item->pelaku_usaha->jenis_pelaku_usaha->id;
        });

        return view('pengenaan_sp.laporan', [
            'title' => 'Laporan Pengenaan Sanksi',
            'pengenaan_sp' => $pengenaan_sp,
            'pengenaan_sp_grouped' => $pengenaan_sp_grouped
        ]);
    }

    public function exportExcel(Request $request)
    {
        $start = $request->start;
        $end   = $request->end;

        $query = PengenaanSP::with(['pelaku_usaha', 'sanksi']);

        if ($start && $end) {
            $query->whereBetween('tanggal_mulai', [$start, $end]);
        }

        $query->orderByRaw("ABS(DATEDIFF(tanggal_selesai, CURDATE())) ASC");

        $data = $query->get();

        if ($start && $end) {
            return Excel::download(
                new PengenaanSPExport($data),
                "pengenaan-sp-{$start}-{$end}.xlsx"
            );
        }

        return Excel::download(
            new PengenaanSPExport($data),
            'pengenaan-sp-all-periode.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $query = PengenaanSP::with(['pelaku_usaha', 'sanksi']);

        // pakai filter kalau ada tanggal
        if ($start && $end) {
            $query->whereBetween('tanggal_mulai', [$start, $end]);
        }

        // urutkan berdasarkan tanggal selesai terdekat ke tanggal hari ini
        $query->orderByRaw("ABS(DATEDIFF(tanggal_selesai, CURDATE())) ASC");

        $data = $query->get();

        $grouped = $data->groupBy(function ($item) {
            return $item->pelaku_usaha->jenis_pelaku_usaha->id; // LEVEL 1
        })->map(function ($items) {
            return $items->groupBy(function ($item) {
                return $item->pelaku_usaha->id; // LEVEL 2
            })->map(function ($items2) {
                return $items2->groupBy(function ($item) {
                    return $item->sanksi->id; // LEVEL 3
                });
            });
        });

        $pdf = PDF::loadView('pengenaan_sp.pdf', [
            'sp' => $data,
            'grouped' => $grouped,
            'tahun' => $start
        ]);

        if ($start && $end) {
            $report = $pdf->stream("pengenaan-sp-{$start}-{$end}.pdf");
        } else {
            $report = $pdf->stream('pengenaan-sp-all-periode.pdf');
        }


        return $report;
    }

    public function generateLaporan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Buat laporan baru
        $laporan = Laporan::create([
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        // Ambil pengenaan_sp berdasarkan bulan–tahun
        $data = PengenaanSP::whereMonth('tanggal_mulai', $bulan)
            ->whereYear('tanggal_mulai', $tahun)
            ->get();

        // Masukkan ke pivot
        foreach ($data as $sp) {
            LaporanItem::create([
                'laporan_id' => $laporan->id,
                'pengenaan_sp_id' => $sp->id
            ]);
        }

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan bulanan berhasil dibuat.');
    }
}
