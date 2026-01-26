<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Laporan;
use App\Models\LaporanItem;
use App\Models\PengenaanSP;
use App\Models\PelakuUsaha;
use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
// use BaconQrCode\Encoder\QrCode;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'title' => 'Laporan Pengenaan Sanksi',
            'laporan' => Laporan::orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get()
        ]);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'nullable|integer|min:2000',
            'perusahaan_id' => 'nullable|exists:pelaku_usaha,id',
            'status_surat' => 'nullable|in:sudah_ditanggapi,belum_ditanggapi',
        ]);

        $bulan = $request->bulan;   // 0 = Semua Bulan
        $tahun = $request->tahun;   // 0 = Semua Tahun
        $perusahaan_id = $request->perusahaan_id;
        $status_surat = $request->status_surat;

        // Cek duplikasi hanya jika bulan & tahun spesifik
        if (!$bulan && !$tahun && !$perusahaan_id && !$status_surat) {
            return back()->with('error', 'Pilih minimal satu filter.');
        }
        // Cek duplikasi laporan
        $laporan = Laporan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('status_surat', $status_surat)
            ->when(
                $perusahaan_id,
                fn($q) =>
                $q->where('pelaku_usaha_id', $perusahaan_id)
            )
            ->first();

        if ($laporan) {
            // hapus item lama
            LaporanItem::where('laporan_id', $laporan->id)->delete();
        } else {
            // buat laporan baru
            $laporan = Laporan::create([
                'bulan' => $bulan,
                'tahun' => $tahun,
                'pelaku_usaha_id' => $perusahaan_id,
                'status_surat' => $status_surat
            ]);
        }

        // Query data Sanksi
        $query = PengenaanSP::query();

        if ($bulan) $query->whereMonth('tanggal_mulai', $bulan);
        if ($tahun) $query->whereYear('tanggal_mulai', $tahun);
        if ($perusahaan_id) $query->where('pelaku_usaha_id', $perusahaan_id);
        if ($status_surat) $query->where('status_surat', $status_surat);

        $data = $query->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        foreach ($data as $sp) {
            LaporanItem::create([
                'laporan_id' => $laporan->id,
                'pengenaan_sp_id' => $sp->id
            ]);
        }

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil diperbarui dengan data terbaru.');
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
        $laporan = Laporan::with([
            'pengenaan_sp.pelaku_usaha.jenis_pelaku_usaha',
            'pengenaan_sp.pengenaan_sp_sanksi.sanksi',
            'pengenaan_sp.jenis_pelanggaran',
            'pengenaan_sp.eskalasi_aktif'
        ])->findOrFail($id);

        $items = $laporan->pengenaan_sp
            ->sortByDesc(fn($sp) => $sp->eskalasi_aktif?->tanggal_mulai)
            ->groupBy([
                fn($sp) => $sp->pelaku_usaha->nama,
                fn($sp) => $sp->pelaku_usaha->jenis_pelaku_usaha->nama,
                fn($sp) => Carbon::parse($sp->eskalasi_aktif->tanggal_mulai)->format('Y-m')
            ]);

        $rekap_perusahaan = $laporan->pengenaan_sp
            ->groupBy(fn($sp) => $sp->pelaku_usaha->nama)
            ->map(function ($group) {
                return [
                    'sudah' => $group->where('status_surat', 'sudah_ditanggapi')->count(),
                    'belum' => $group->where('status_surat', 'belum_ditanggapi')->count(),
                    'total' => $group->count(),
                ];
            });

        $jumlah_status = [
            'belum' => $laporan->pengenaan_sp
                ->where('status_surat', 'belum_ditanggapi')
                ->count(),

            'sudah' => $laporan->pengenaan_sp
                ->where('status_surat', 'sudah_ditanggapi')
                ->count(),

            'pending' => $laporan->pengenaan_sp
                ->where('status_surat', 'pending')
                ->count(),
        ];

        $urutan = sprintf('%03d', $laporan->id);
        $bulan = $laporan->updated_at->format('m');
        $tahun = $laporan->updated_at->format('Y');
        $nomor_laporan = "UD.01.00/{$urutan}/BAPPEBTI.3/ND.DK-S/{$bulan}/{$tahun}";
        $nama_bulan = Carbon::createFromDate($bulan, 1)->translatedFormat('F');

        $qrBase64 = null;
        if ($laporan->approval_hash) {
            $verifyUrl = config('app.url') . route('laporan.verify', $laporan->approval_hash, false);

            $qrBase64 = base64_encode(
                QrCode::format('png')
                    ->size(160)
                    ->margin(1)
                    ->generate($verifyUrl)
            );
        }

        $pdf = PDF::loadView('laporan.pdf', compact('laporan', 'items', 'jumlah_status', 'nomor_laporan', 'qrBase64', 'rekap_perusahaan'));

        return $pdf->stream("NOTA DINAS {$nama_bulan}-{$laporan->tahun}.pdf");
    }

    // public function approve($id)
    // {
    //     $laporan = Laporan::findOrFail($id);
    //     $laporan->update([
    //         'status_disetujui' => !$laporan->status_disetujui
    //     ]);

    //     return back()->with('success', 'Status laporan diperbarui.');
    // }

    public function approve(Request $request)
    {
        $request->validate([
            'laporan_id' => 'required|exists:laporan,id',
            'status' => 'required',
            'catatan' => 'nullable|string'
        ]);

        if (auth()->user()->role != 'ketua_tim') {
            abort(403, 'Anda tidak memiliki akses (Hanya Ketua Tim).');
        }

        $laporan = Laporan::findOrFail($request->laporan_id);

        // 🔒 Payload JWT (ENUM SAFE)
        $payload = [
            'laporan_id' => $laporan->id,
            'status' => $request->status, // setuju / dikembalikan
            'approved_by' => auth()->id(),
            'role' => 'ketua_tim',
            'iat' => time()
        ];

        $jwt = JWT::encode($payload, config('app.key'), 'HS256');

        // 🔑 Hash untuk QR
        $hash = hash_hmac(
            'sha256',
            $laporan->id . '|' . $request->status . '|' . auth()->id() . '|' . $payload['iat'],
            config('app.key')
        );

        $laporan->update([
            'status_persetujuan' => $request->status,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'signature_jwt' => $jwt,
            'approval_hash' => $hash,
            'approval_ip' => request()->ip(),
            'approval_agent' => request()->userAgent(),
            'catatan' => $request->catatan,
            'user_id' => auth()->user()->id
        ]);

        return back()->with('success', 'Status berhasil diperbarui');
    }

    public function verify($hash)
    {
        $laporan = Laporan::where('approval_hash', $hash)->firstOrFail();

        try {
            $decoded = JWT::decode(
                $laporan->signature_jwt,
                new Key(config('app.key'), 'HS256')
            );
        } catch (\Exception $e) {
            abort(403, 'Tanda tangan digital tidak valid');
        }

        // Cocokkan status enum
        if ($decoded->status !== $laporan->status_persetujuan) {
            abort(403, 'Data persetujuan tidak konsisten');
        }

        $user = User::findOrFail($decoded->approved_by);

        return view('laporan.verify', compact('laporan', 'decoded', 'user'));
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
