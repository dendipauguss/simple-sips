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
            'title' => 'Data Laporan Pengenaan Sanksi',
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
            'perusahaan_id' => 'nullable|exists:pelaku_usaha,id'
        ]);

        $bulan = $request->bulan;   // 0 = Semua Bulan
        $tahun = $request->tahun;   // 0 = Semua Tahun
        $perusahaan_id = $request->perusahaan_id;

        // Cek duplikasi hanya jika bulan & tahun spesifik
        // Cek duplikasi laporan
        $exists = Laporan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->when(
                $perusahaan_id,
                fn($q) =>
                $q->where('pelaku_usaha_id', $perusahaan_id)
            )
            ->exists();

        if ($exists) {
            return back()->with('error', 'Laporan dengan filter tersebut sudah ada.');
        }

        // Query data Sanksi
        $query = PengenaanSP::query();

        if ($bulan) $query->whereMonth('tanggal_mulai', $bulan);
        if ($tahun) $query->whereYear('tanggal_mulai', $tahun);
        if ($perusahaan_id) $query->where('pelaku_usaha_id', $perusahaan_id);

        $data = $query->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        // Simpan laporan
        $laporan = Laporan::create([
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pelaku_usaha_id' => $perusahaan_id
        ]);

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
        $laporan = Laporan::with(['pengenaan_sp'])->findOrFail($id);

        $items = $laporan->pengenaan_sp
            ->load(['pelaku_usaha.jenis_pelaku_usaha', 'sanksi', 'jenis_pelanggaran'])
            ->groupBy([
                fn($item) => $item->pelaku_usaha->nama,
                fn($item) => $item->pelaku_usaha->jenis_pelaku_usaha->nama,
                fn($item) => $item->sanksi->nama,
            ]);

        $jumlah_status = [
            'belum' => $laporan->pengenaan_sp
                ->where('status_surat', 'belum_ditanggapi')
                ->count(),

            'sudah' => $laporan->pengenaan_sp
                ->where('status_surat', 'sudah_ditanggapi')
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

        $pdf = PDF::loadView('laporan.pdf', compact('laporan', 'items', 'jumlah_status', 'nomor_laporan', 'qrBase64'));

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

        dd($request);
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
