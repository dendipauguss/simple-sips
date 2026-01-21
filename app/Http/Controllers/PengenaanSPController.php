<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Carbon\Carbon;
use Yaza\LaravelGoogleDriveStorage\Gdrive;
use Illuminate\Support\Facades\Response;
use App\Services\OneDriveService;
use App\Services\GoogleDriveService;
use App\Exports\PengenaanSPExport;
use App\Imports\PengenaanSPImport;
use App\Models\PengenaanSP;
use App\Models\PelakuUsaha;
use App\Models\JenisPelakuUsaha;
use App\Models\KategoriSP;
use App\Models\JenisPelanggaran;
use App\Models\NotaDinas;
use App\Models\Files;
use App\Models\Laporan;
use App\Models\Sanksi;
use App\Models\LaporanItem;
use App\Models\DasarPengenaanSanksi;
use App\Models\PengenaanSPEskalasi;
use Illuminate\Support\Str;

class PengenaanSPController extends Controller
{
    public function index(Request $request)
    {

        $query = PengenaanSP::query()->with([
            'sanksi', // 🔥 WAJIB
            'pelaku_usaha.jenis_pelaku_usaha',
            'jenis_pelanggaran',
            'user',
            'eskalasi_aktif.sanksi'
        ]);

        $status = $request->status;

        if ($status) {
            $query->where('status_surat', $status);
        }

        $bulanList = PengenaanSP::selectRaw('MONTH(tanggal_mulai) as bulan')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('bulan');

        $tahunList = PengenaanSP::selectRaw('YEAR(tanggal_mulai) as tahun')
            ->groupBy('tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $pengenaan_sp = $query
            ->with([
                'sanksi',
                'pelaku_usaha.jenis_pelaku_usaha',
                'jenis_pelanggaran',
                'user',
                'eskalasi_aktif.sanksi'
            ])
            ->orderByRaw("
                CASE
                    WHEN status_surat = 'belum_ditanggapi' AND tanggal_selesai < CURDATE() THEN 1
                    WHEN status_surat = 'belum_ditanggapi' THEN 2
                    WHEN status_surat = 'pending' THEN 3
                    WHEN status_surat = 'sudah_ditanggapi' THEN 4
                    ELSE 5
                END
            ")
            ->orderByRaw("
                CASE
                    WHEN status_surat IN ('belum_ditanggapi', 'pending')
                    THEN ABS(DATEDIFF(tanggal_selesai, CURDATE()))
                    ELSE 999999
                END
            ")
            ->get();

        $perusahaan = PelakuUsaha::whereHas('pengenaan_sp')
            ->orderBy('nama')
            ->get();

        return view('pengenaan_sp.index', [
            'title' => 'Monitoring Pengenaan Sanksi',
            'pengenaan_sp' => $pengenaan_sp,
            'bulanList' => $bulanList,
            'tahunList' => $tahunList,
            'perusahaan' => $perusahaan
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
            'dasar_pengenaan_sanksi' => DasarPengenaanSanksi::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_nota_dinas' => 'required|string',
            'tanggal_nota_dinas' => 'required|date',
            'dasar_pengenaan_sanksi_id' => 'required|integer',

            'no_surat.*' => 'required|string|distinct|unique:pengenaan_sp,no_surat',
            'tanggal_mulai.*' => 'required|date',
            'tanggal_selesai.*' => 'required|date',
            'sanksi_id.*' => 'required|integer|exists:sanksi,id',
            'is_denda.*' => 'nullable|in:0,1',
            'jenis_pelaku_usaha_id.*' => 'required',
            'pelaku_usaha_id.*' => 'required',
            'jenis_pelanggaran_id.*' => 'required',
            'kategori_sp_id.*' => 'required',
            'detail_pelanggaran.*' => 'nullable',
        ], [
            'no_nota_dinas.required' => 'Nomor wajib diisi kakak',
            'tanggal_nota_dinas.required' => 'Tanggal wajib diisi kakak',

            'no_surat.*.required' => 'Nomor wajib diisi kakak',
            'is_denda.*.required' => 'Kolom tidak terisi',
            'tanggal_mulai.*.required' => 'Pilih tanggalnya dulu kakak',
            'tanggal_selesai.*.required' => 'Pilih tanggalnya dulu kakak',
            'sanksi_id.*.required' => 'Pilih dulu sanksinya kakak',
            'sanksi_id.*.integer' => 'Tipe datanya tidak sesuai',
            'jenis_pelaku_usaha_id.*.required' => 'Data tidak ditemukan',
            'pelaku_usaha_id.*.required' => 'Pilih Perusahaannya dulu kakak',
            'jenis_pelanggaran_id.*.required' => 'Data tidak ditemukan',
            'kategori_sp_id.*.required' => 'Pilih kategorinya dulu kakak'
        ]);


        DB::transaction(function () use ($request) {
            // Simpan Nota Dinas
            $nota_dinas = NotaDinas::create([
                'no_nota_dinas' => $request->no_nota_dinas,
                'tanggal_nota_dinas' => $request->tanggal_nota_dinas,
                'dasar_pengenaan_sanksi_id' => $request->dasar_pengenaan_sanksi_id
            ]);

            $dasar = DasarPengenaanSanksi::find($request->dasar_pengenaan_sanksi_id)->nama;
            $tahun = \Carbon\Carbon::parse($request->tanggal_nota_dinas)->format('Y');
            $noNota = $this->sanitizeFolderName($request->no_nota_dinas);

            $base = config('filesystems.disks.google.root'); // env('GOOGLE_DRIVE_FOLDER')

            $folderPath = "{$base}/{$tahun}/{$dasar}/{$noNota}";

            $filename = "ND-{$noNota}";

            $this->uploadFileToGDrive(
                $request->file('nota_dinas_file'),
                'nota_dinas',
                $nota_dinas->id,
                'surat',
                $folderPath,
                $filename
            );

            // ---- 2. Simpan data awal ----
            foreach ($request->no_surat as $i => $nilai) {
                $sp = PengenaanSP::create([
                    'no_surat' => $nilai,
                    'tanggal_mulai' => $request->tanggal_mulai[$i],
                    'tanggal_selesai' => $request->tanggal_selesai[$i],
                    'nota_dinas_id' => $nota_dinas->id,
                    'jenis_pelaku_usaha_id' => $request->jenis_pelaku_usaha_id[$i],
                    'pelaku_usaha_id' => $request->pelaku_usaha_id[$i],
                    'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id[$i],
                    'kategori_sp_id' => $request->kategori_sp_id[$i],
                    'detail_pelanggaran' => $request->detail_pelanggaran[$i],
                    'user_id' => auth()->id(),
                ]);

                $sanksiUtamaId = $request->sanksi_id[$i];
                $isDenda       = $request->is_denda[$i] ?? 0;

                // ambil data sanksi utama
                $sanksiUtama = Sanksi::find($sanksiUtamaId);

                // simpan sanksi utama
                DB::table('pengenaan_sp_sanksi')->insert([
                    'pengenaan_sp_id' => $sp->id,
                    'sanksi_id' => $sanksiUtamaId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // jika sanksi utama BUKAN denda & denda dicentang
                if ($sanksiUtama->kode_surat !== 'DA' && $isDenda == 1) {

                    $idDenda = Sanksi::where('kode_surat', 'DA')->value('id');

                    DB::table('pengenaan_sp_sanksi')->insert([
                        'pengenaan_sp_id' => $sp->id,
                        'sanksi_id' => $idDenda,
                        'nominal_denda' => $request->nominal_denda[$i],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $eskalasi = PengenaanSPEskalasi::create([
                    'pengenaan_sp_id' => $sp->id,
                    'sanksi_id'       => $sanksiUtamaId,
                    'level'           => 1,
                    'no_surat'        => $sp->no_surat,
                    'tanggal_mulai'   => $sp->tanggal_mulai,
                    'tanggal_selesai' => $sp->tanggal_selesai,
                    'is_denda'        => $isDenda,
                    'nominal_denda'   => $isDenda ? $request->nominal_denda[$i] : null,
                    'status'          => 'aktif',
                ]);

                $filename = "SP-{$eskalasi->level}-{$this->sanitizeFolderName($eskalasi->no_surat)}";

                $this->uploadFileToGDrive($request->file("lampiran.$i"), 'pengenaan_sp_eskalasi', $eskalasi->id, 'surat', $folderPath, $filename);
            }
        });

        return redirect()->route('pengenaan-sp.index')
            ->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        return view('pengenaan_sp.show', [
            'title' => 'Detail Sanksi',
            'sp' => PengenaanSP::with([
                'pengenaan_sp_sanksi.sanksi',
                'pelaku_usaha',
                'jenis_pelanggaran',
                'user'
            ])->findOrFail($id)
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

    public function destroy($id)
    {
        $pengenaan_sp = PengenaanSP::findOrFail($id);

        $file = Files::findOrFail($pengenaan_sp->file->id);

        $hapus_file_gdrive = $this->deleteFileFromGDrive($file->google_file_path);

        if ($hapus_file_gdrive) {
            $pesan = 'Dan Berhasil hapus file google drive';
        } else {
            $pesan = 'Tetapi Gagal hapus file google drive';
        }

        $file->delete();
        $pengenaan_sp->delete();

        return redirect()->route('pengenaan-sp.index')->with('success', 'Data berhasil dihapus! ' . $pesan);
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

    public function uploadDokumenTanggapan(Request $request)
    {
        // dd($request);
        $request->validate([
            'pengenaan_sp_id' => 'required|exists:pengenaan_sp,id',
            'tanggapan' => 'required|string',
            'lampiran.*'    => 'nullable|file|max:5120', // 5 MB
            'dasar_pengenaan_sanksi_id' => 'required|integer',
            'tanggal_nota_dinas' => 'required|date',
            'no_nota_dinas' => 'required|string'
        ], [
            'pengenaan_sp_id.required' => 'ID tidak ditemukan',
            'tanggapan.required' => 'Tidak boleh kosong kakak'
        ]);

        $dasar = DasarPengenaanSanksi::find($request->dasar_pengenaan_sanksi_id)->nama;
        $tahun = \Carbon\Carbon::parse($request->tanggal_nota_dinas)->format('Y');
        $noNota = $this->sanitizeFolderName($request->no_nota_dinas);

        $base = config('filesystems.disks.google.root'); // env('GOOGLE_DRIVE_FOLDER')
        $folderPath = "{$base}/{$tahun}/{$dasar}/{$noNota}";
        $pengenaan_sp = PengenaanSP::findOrFail($request->pengenaan_sp_id);

        $filename = "TANGGAPAN-SP-{$this->sanitizeFolderName($pengenaan_sp->no_surat)}";

        // Panggil fungsi upload file yang sudah kamu buat sebelumnya
        if (!empty($request->lampiran)) {
            $this->uploadFileToGDrive($request->lampiran, 'pengenaan_sp', $request->pengenaan_sp_id, 'bebas', $folderPath, $filename);
        }
        $pengenaan_sp->tanggapan = $request->tanggapan;
        $pengenaan_sp->status_surat = 'sudah_ditanggapi';
        $pengenaan_sp->save();

        return back()->with('success', 'Bukti pendukung berhasil diupload.');
    }

    public function hapusDokumen($id)
    {
        $file = Files::findOrFail($id);
        if (!empty($file)) {
            Storage::disk('public')->delete($file->url_path);
            $file->delete();
        }

        return back()->with('success', 'Data berhasil dihapus!');
    }

    public function eskalasi($id)
    {
        $sp = PengenaanSP::with([
            'eskalasi' => function ($q) {
                $q->orderBy('level');
            }
        ])->findOrFail($id);

        $kodeSanksiDipakai = $sp->eskalasi
            ->pluck('sanksi.kode_surat')
            ->filter()
            ->toArray();
        $jumlahSP = collect($kodeSanksiDipakai)
            ->where(fn($kode) => $kode === 'SP')
            ->count();

        // eskalasi yang sedang aktif
        $eskalasiAktif = $sp->eskalasi->where('status', 'aktif')->first();

        $sanksi_kecuali = [];

        // selain SP → kalau sudah dipakai, exclude
        foreach ($kodeSanksiDipakai as $kode) {
            if ($kode !== 'SP') {
                $sanksi_kecuali[] = $kode;
            }
        }

        // SP → boleh maksimal 3 kali
        if ($jumlahSP >= 3) {
            $sanksi_kecuali[] = 'SP';
        }

        $sanksi = Sanksi::whereNotIn('kode_surat', $sanksi_kecuali)->get();

        // validasi jatuh tempo
        // if (!$eskalasiAktif || now()->lte($eskalasiAktif->tanggal_selesai)) {
        //     abort(403, 'Sanksi belum melewati tanggal jatuh tempo');
        // }

        return view('pengenaan_sp.eskalasi', [
            'title'          => 'Eskalasi Sanksi',
            'sp'             => $sp,
            'eskalasiAktif'  => $eskalasiAktif,
            'nextLevel'      => $sp->eskalasi->max('level') + 1,
            'sanksi' => $sanksi
        ]);
    }

    public function eskalasi_store(Request $request, $id)
    {
        $request->validate([
            'no_surat'        => 'required|string',
            'sanksi_id'       => 'required|integer',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_denda'        => 'required|in:0,1',
            'nominal_denda'   => 'required_if:is_denda,1|nullable|numeric|min:0',
            'dokumen'         => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $sp = PengenaanSP::with('eskalasi')->findOrFail($id);

        $eskalasiAktif = $sp->eskalasi
            ->where('status', 'aktif')
            ->first();

        $sanksi = Sanksi::findOrFail($request->sanksi_id);

        // pengaman
        // if (!$eskalasiAktif) {
        //     return back()->with('error', 'Tidak ada eskalasi aktif');
        // }
        // if ($sp->eskalasi()->where('status', 'aktif')->exists()) {
        //     throw new \Exception('Masih ada eskalasi aktif');
        // }

        // if (now()->lte($eskalasiAktif->tanggal_selesai)) {
        //     return back()->with('error', 'Belum melewati tanggal jatuh tempo');
        // }

        if ($eskalasiAktif->level == 3 && $sanksi->kode_surat == 'SP') {
            return back()->with('error', 'SP Maksimal 3 kali sampai SP 3!');
        }

        if ($request->tanggal_selesai <= $eskalasiAktif->tanggal_selesai) {
            return back()->with('error', 'Tanggal jatuh tempo jangan sama atau kurang dari tanggal jatuh tempo sebelumnya!');
        }

        DB::transaction(function () use ($request, $sp, $eskalasiAktif) {

            // 1. Tutup eskalasi sebelumnya
            $eskalasiAktif->update([
                'status' => 'selesai'
            ]);

            // 2. Simpan eskalasi baru
            $eskalasi_baru = PengenaanSpEskalasi::create([
                'pengenaan_sp_id' => $sp->id,
                'sanksi_id'       => $request->sanksi_id, // jenis sanksi tetap
                'level'           => $eskalasiAktif->level + 1,
                'no_surat'        => $request->no_surat,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'is_denda'        => $request->is_denda,
                'nominal_denda'   => $request->is_denda
                    ? $request->nominal_denda
                    : null,
                'status'          => 'aktif',
            ]);

            $dasar = DasarPengenaanSanksi::find($eskalasi_baru->pengenaan_sp->jenis_pelanggaran->dasar_pengenaan_sanksi_id)->nama;
            $tahun = \Carbon\Carbon::parse($eskalasi_baru->pengenaan_sp->nota_dinas->tanggal_nota_dinas)->format('Y');
            $noNota = $this->sanitizeFolderName($eskalasi_baru->pengenaan_sp->nota_dinas->no_nota_dinas);

            $base = config('filesystems.disks.google.root'); // env('GOOGLE_DRIVE_FOLDER')
            $folderPath = "{$base}/{$tahun}/{$dasar}/{$noNota}";
            $pengenaan_sp = PengenaanSP::findOrFail($eskalasi_baru->pengenaan_sp_id);

            $filename = "SP-{$eskalasi_baru->level}-{$this->sanitizeFolderName($pengenaan_sp->no_surat)}";
            // 3. Upload dokumen → melekat ke eskalasi
            $this->uploadFileToGDrive(
                $request->file('dokumen'),
                'pengenaan_sp_eskalasi',
                $eskalasi_baru->id,
                'surat',
                $folderPath,
                $filename // ⬅️ identitas dokumen pakai no_surat
            );
        });

        return redirect()
            ->route('pengenaan-sp.index')
            ->with('success', 'Eskalasi sanksi berhasil disimpan');
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

    public function importView()
    {
        return view('pengenaan_sp.import', [
            'title' => 'Import Excel Pengenaan Sanksi',
            'pengenaan_sp' => PengenaanSP::all()
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new PengenaanSPImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diimport');
    }

    private function uploadFile(UploadedFile|array|null $files, string $table_name, int $table_id, string $tipe_dokumen)
    {
        if (!$files) return;

        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {

            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs(
                "uploads/{$table_name}",
                $filename,
                'public'
            );

            Files::create([
                'table_name'    => $table_name,
                'table_id'      => $table_id,
                'tipe'          => $tipe_dokumen,
                'filename'      => $filename,
                'original_name' => $file->getClientOriginalName(),
                'url_path'      => 'storage/' . $path,
            ]);
        }
    }

    private function uploadFilesToOneDrive(
        UploadedFile|array|null $files,
        string $table_name,
        int $table_id,
        string $tipe_dokumen,
        OneDriveService $oneDrive
    ) {
        if (!$files) return;

        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {

            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Upload ke OneDrive
            $result = $oneDrive->upload(
                auth()->id(),
                $file->getRealPath(),
                $filename,
                "uploads/{$table_name}"
            );

            // Simpan metadata ke DB
            Files::create([
                'table_name'    => $table_name,
                'table_id'      => $table_id,
                'tipe'          => $tipe_dokumen,
                'filename'      => $filename,
                'original_name' => $file->getClientOriginalName(),
                'url_path'      => $result['webUrl'], // URL OneDrive
                'drive_file_id' => $result['id'],     // PENTING
            ]);
        }
    }

    private function uploadFileToGDrive(UploadedFile|array|null $files, string $table_name, int $table_id, string $tipe_dokumen, string $folderPath, string $filenamed)
    {
        if (!$files) return;

        if (!is_array($files)) {
            $files = [$files];
        }

        // 🔑 HITUNG FILE YANG SUDAH ADA
        $no = Files::where('table_name', $table_name)
            ->where('table_id', $table_id)
            ->where('tipe', $tipe_dokumen)
            ->count() + 1;

        foreach ($files as $file) {

            $filename = sprintf('%s-%02d.%s', $filenamed, $no++, $file->getClientOriginalExtension());

            $fullPath = "{$folderPath}/{$filename}";

            // ⬅️ INI YANG PALING PENTING
            Gdrive::put($fullPath, $file);

            // Ambil metadata file terakhir
            $content = Gdrive::all($folderPath);
            $uploaded = $content->last();
            // $uploaded = Gdrive::all($folderPath)->last();
            $meta = $uploaded?->extraMetadata() ?? [];

            Files::create([
                'table_name' => $table_name,
                'table_id' => $table_id,
                'tipe' => $tipe_dokumen,
                'filename' => $meta['filename'] ?? $filename,
                'original_name' => $file->getClientOriginalName(),
                'google_file_id' => $meta['id'] ?? null,
                'google_file_path' => $uploaded?->path(),
                // 'url_path' => isset($meta['id'])
                //     ? 'https://drive.google.com/file/d/' . $meta['id']
                //     : null,
                'file_token' => Str::uuid()
            ]);
        }
    }

    private function deleteFileFromGDrive($file_path): bool
    {
        try {
            Gdrive::delete($file_path);
            return true;
        } catch (\Throwable $e) {
            Log::error('GDrive delete failed', [
                'path' => $file_path,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    private function getOneDriveAccessToken()
    {
        $token = DB::table('ms_token')
            ->where('user_id', auth()->id())
            ->first();

        // Kalau belum expired → langsung pakai
        if ($token && now()->lt($token->expires_at)) {
            return $token->access_token;
        }

        // Refresh token
        $response = Http::asForm()->post(
            'https://login.microsoftonline.com/' . config('services.microsoft.tenant_id') . '/oauth2/v2.0/token',
            [
                'client_id' => config('services.microsoft.client_id'),
                'client_secret' => config('services.microsoft.client_secret'),
                'grant_type' => 'refresh_token',
                'refresh_token' => $token->refresh_token,
                'scope' => 'offline_access Files.ReadWrite',
            ]
        );

        $newToken = $response->json();

        DB::table('ms_token')
            ->where('user_id', auth()->id())
            ->update([
                'access_token'  => $newToken['access_token'],
                'expires_at'    => now()->addSeconds($newToken['expires_in']),
            ]);

        return $newToken['access_token'];
    }

    private function sanitizeFolderName(string $name): string
    {
        return str_replace(['/', '\\'], '-', $name);
    }
}
