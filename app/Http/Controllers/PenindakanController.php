<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenindakanExport;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Models\Penindakan;
use App\Models\PerintahSanksi;
use App\Models\Perusahaan;
use App\Models\Sanksi;
use App\Models\FilesModel;

class PenindakanController extends Controller
{
    public function index()
    {
        return view('penindakan.index', [
            'title' => 'Pengenaan Sanksi',
            'penindakan' => Penindakan::where('user_id', auth()->user()->id)->with('files')->get()
        ]);
    }

    public function create()
    {
        return view('penindakan.create', [
            'title' => 'Tambah Laporan',
            'perusahaan' => Perusahaan::all(),
            'sanksi' => Sanksi::all(),
            'perintah_sanksi' => PerintahSanksi::all(),
            'selected_perintah_id' => $selected_perintah_id ?? '' // opsional
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date',
            'perihal'          => 'required|string',
            'perusahaan_id'    => 'required|integer',
            'perintah_id'      => 'required|array', // multiple checkbox
            'perintah_id.*'    => 'integer',
            'perintah_lainnya' => 'nullable|string',
            'deskripsi'        => 'nullable|string',
        ], [
            'perihal.required' => 'Perihal wajib diisi',
            'perintah_id.required' => 'Perintah wajib diisi'
        ]);
        $user_id = auth()->user()->id;
        // dd($request, $user_id);
        // 1️⃣ Simpan tabel penindakan utama
        $penindakan = Penindakan::create([
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai,
            'perihal'          => $request->perihal,
            'perusahaan_id'    => $request->perusahaan_id,
            'sanksi_id'        => $request->sanksi_id,
            'deskripsi'        => $request->deskripsi,
            'perintah_lainnya' => $request->perintah_lainnya,
            'status'           => 'belum',
            'user_id'          => $user_id
        ]);

        // 2️⃣ Simpan data pivot (perintah sanksi multiple)
        $penindakan->perintah()->attach($request->perintah_id);

        return redirect('penindakan')->with('success', 'Data penindakan berhasil disimpan');
    }

    public function edit($id)
    {
        $title = 'Edit Pengenaan Sanksi';
        $penindakan = Penindakan::with('perintah')->findOrFail($id);

        $perusahaan = Perusahaan::all();
        $sanksi = Sanksi::all();

        // Ambil daftar perintah berdasarkan setiap sanksi
        $perintah_sanksi = PerintahSanksi::all();

        // Ambil perintah yang sudah dipilih (id saja)
        $perintah_terpilih = $penindakan->perintah->pluck('id')->toArray();

        return view('penindakan.edit', compact(
            'title',
            'penindakan',
            'perusahaan',
            'sanksi',
            'perintah_sanksi',
            'perintah_terpilih'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date',
            'perihal'           => 'required|string',
            'perusahaan_id'     => 'required',
            'sanksi_id'         => 'required',
            'deskripsi'         => 'nullable|string',
            'perintah_id'       => 'array', // checkbox
        ]);

        $penindakan = Penindakan::findOrFail($id);

        $penindakan->update([
            'tanggal_mulai'     => $request->tanggal_mulai,
            'tanggal_selesai'   => $request->tanggal_selesai,
            'perihal'           => $request->perihal,
            'perusahaan_id'     => $request->perusahaan_id,
            'sanksi_id'         => $request->sanksi_id,
            'deskripsi'         => $request->deskripsi,
            'perintah_lainnya'  => $request->perintah_lainnya,
        ]);

        // Sync checkbox (hapus lama & simpan baru)
        $penindakan->perintah()->sync($request->perintah_id ?? []);

        return redirect('penindakan')
            ->with('success', 'Data penindakan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penindakan = Penindakan::findOrFail($id);
        $penindakan->delete();

        return redirect()->route('penindakan.index')->with('success', 'Data pengenaan sanksi berhasil dihapus!');
    }

    // public function updateStatus(Request $request, $pivotId)
    // {
    //     DB::table('penindakan_perintah_sanksi')
    //         ->where('id', $pivotId)
    //         ->update(['status' => $request->status]);

    //     // dapatkan penindakan_id dari pivot
    //     $pivot = DB::table('penindakan_perintah_sanksi')->where('id', $pivotId)->first();

    //     // hitung status terbaru
    //     $this->updatePenindakanStatus($pivot->penindakan_id);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Status perintah berhasil diperbarui'
    //     ]);
    // }

    public function updatePerintahStatus(Request $request, $id)
    {
        if ($request->tipe == 'lainnya') {

            // id adalah id penindakan
            $penindakan_id = $id;

            DB::table('penindakan')
                ->where('id', $penindakan_id)
                ->update(['status_lainnya' => $request->status]);
        } else {

            // id adalah pivot id
            DB::table('penindakan_perintah_sanksi')
                ->where('id', $id)
                ->update(['status' => $request->status]);

            // ambil penindakan_id dari pivot
            $pivot = DB::table('penindakan_perintah_sanksi')->where('id', $id)->first();
            $penindakan_id = $pivot->penindakan_id;
        }

        // hitung ulang status penindakan
        $this->updatePenindakanStatus($penindakan_id);

        return response()->json(['success' => true]);
    }

    public function uploadDokumen(Request $request)
    {
        $request->validate([
            'penindakan_id' => 'required|exists:penindakan,id',
            'lampiran.*'    => 'required|file|max:5120', // 5 MB
        ]);

        // Panggil fungsi upload file yang sudah kamu buat sebelumnya
        $this->uploadFile($request, 'penindakan', $request->penindakan_id);

        return back()->with('success', 'Bukti pendukung berhasil diupload.');
    }

    public function laporan(Request $request)
    {
        $query = Penindakan::query();

        if ($request->start && $request->end) {
            // Filter rentang
            $query->whereBetween('tanggal_mulai', [$request->start, $request->end]);
        } elseif ($request->start) {
            // Filter tanggal mulai saja
            $query->whereDate('tanggal_mulai', '>=', $request->start);
        } elseif ($request->end) {
            // Filter tanggal selesai saja
            $query->whereDate('tanggal_mulai', '<=', $request->end);
        }

        $penindakan = $query->orderBy('tanggal_mulai', 'desc')->get();

        return view('penindakan.laporan', [
            'title' => 'Laporan Pengenaan Sanksi',
            'penindakan' => $penindakan
        ]);
    }

    public function exportExcel(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $query = Penindakan::with(['perusahaan', 'sanksi']);

        if ($start && $end) {
            $query->whereBetween('tanggal_mulai', [$start, $end]);
        }

        $query->orderByRaw("ABS(DATEDIFF(tanggal_selesai, CURDATE())) ASC");

        return Excel::download(new PenindakanExport($query->get()), 'penindakan.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $query = Penindakan::with(['perusahaan', 'sanksi']);

        // pakai filter kalau ada tanggal
        if ($start && $end) {
            $query->whereBetween('tanggal_mulai', [$start, $end]);
        }

        // urutkan berdasarkan tanggal selesai terdekat ke tanggal hari ini
        $query->orderByRaw("ABS(DATEDIFF(tanggal_selesai, CURDATE())) ASC");

        $data = $query->get();

        $pdf = PDF::loadView('penindakan.pdf', [
            'data' => $data
        ]);

        return $pdf->download('penindakan.pdf');
    }

    private function uploadFile(Request $request, $tabel_name, $tabel_id)
    {
        foreach ($request->file('lampiran') as $file) {

            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            // simpan ke storage/public/uploads/penindakan
            $path = $file->storeAs('uploads/' . $tabel_name, $filename, 'public');


            // simpan ke database
            FilesModel::create([
                'table_name' => $tabel_name,
                'table_id'   => $tabel_id,
                'filename'   => $filename,
                'url_path'   => $path,
            ]);
        }
    }
    private function updatePenindakanStatus($penindakan_id)
    {
        // total perintah bawaan
        $perintah_asli = DB::table('penindakan_perintah_sanksi')
            ->where('penindakan_id', $penindakan_id)
            ->count();

        // total perintah bawaan yang sudah
        $sudah_bawaan = DB::table('penindakan_perintah_sanksi')
            ->where('penindakan_id', $penindakan_id)
            ->where('status', 'sudah')
            ->count();

        // cek perintah lainnya
        $penindakan = DB::table('penindakan')
            ->where('id', $penindakan_id)
            ->first();

        $ada_lainnya = !empty($penindakan->perintah_lainnya);
        $sudah_lainnya = ($penindakan->status_lainnya == 'sudah') ? 1 : 0;

        // hitung total
        $total = $perintah_asli + ($ada_lainnya ? 1 : 0);
        $total_sudah = $sudah_bawaan + $sudah_lainnya;

        // tentukan status
        if ($total_sudah == 0) {
            $status = 'belum';
        } elseif ($total_sudah < $total) {
            $status = 'pending';
        } else {
            $status = 'selesai';
        }

        // update
        DB::table('penindakan')
            ->where('id', $penindakan_id)
            ->update(['status' => $status]);
    }
}
