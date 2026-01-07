<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PengenaanSP;
use App\Models\JenisPelanggaran;
use App\Models\PelakuUsaha;
use App\Models\JenisPelakuUsaha;
use App\Models\Sanksi;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun;
        $jenis = JenisPelanggaran::all();

        $labels_bar = [];
        $sudah_bar = [];
        $belum_bar = [];
        $total_bar = [];

        foreach ($jenis as $jp) {
            $labels_bar[] = $jp->nama;

            $sudah_bar[] = PengenaanSP::where('jenis_pelanggaran_id', $jp->id)
                ->where('status_surat', 'sudah_ditanggapi')
                ->count();

            $belum_bar[] = PengenaanSP::where('jenis_pelanggaran_id', $jp->id)
                ->where('status_surat', 'belum_ditanggapi')
                ->count();

            $total_bar[] = PengenaanSP::where('jenis_pelanggaran_id', $jp->id)
                ->count();
        }

        $belum = PengenaanSP::where('status_surat', 'belum_ditanggapi')->count();
        $selesai = PengenaanSP::where('status_surat', 'sudah_ditanggapi')->count();

        $sanksi_per_periode = DB::table('pengenaan_sp')
            ->select(
                DB::raw("DATE_FORMAT(tanggal_mulai, '%Y-%m') as periode"),
                DB::raw("SUM(status_surat = 'sudah_ditanggapi') as sudah"),
                DB::raw("SUM(status_surat = 'belum_ditanggapi') as belum"),
                DB::raw("COUNT(*) as total_sanksi")
            )
            ->when($tahun, fn($q) => $q->whereYear('tanggal_mulai', $tahun))
            ->groupBy('periode')
            ->orderBy('periode')
            ->get()
            ->map(function ($row) {
                $row->periode_label = Carbon::createFromFormat('Y-m', $row->periode)
                    ->locale('id')
                    ->translatedFormat('F Y'); // 1 November 2001
                return $row;
            });

        $top_jenis_pelaku = JenisPelakuUsaha::withCount([
            'pengenaan_sp as total_sanksi' => fn($q) =>
            $q->when(
                $tahun,
                fn($qq) =>
                $qq->whereYear('tanggal_mulai', $tahun)
            ),
            'pengenaan_sp as sudah_ditanggapi' => fn($q) =>
            $q->where('status_surat', 'sudah_ditanggapi')
                ->when(
                    $tahun,
                    fn($qq) =>
                    $qq->whereYear('tanggal_mulai', $tahun)
                ),
            'pengenaan_sp as belum_ditanggapi' => fn($q) =>
            $q->where('status_surat', 'belum_ditanggapi')
                ->when(
                    $tahun,
                    fn($qq) =>
                    $qq->whereYear('tanggal_mulai', $tahun)
                )
        ])
            ->orderByDesc('total_sanksi')
            ->get()
            ->map(function ($item) {
                $item->persen = $item->total_sanksi > 0
                    ? round(($item->sudah_ditanggapi / $item->total_sanksi) * 100, 1)
                    : 0;
                return $item;
            });

        $sanksi_per_bentuk = Sanksi::withCount([
            'pengenaan_sp' => fn($q) =>
            $q->when($tahun, fn($qq) => $qq->whereYear('tanggal_mulai', $tahun))
        ])
            ->orderByDesc('pengenaan_sp_count')
            ->get();

        $sanksi_per_pelanggaran = JenisPelanggaran::withCount([
            'pengenaan_sp' => fn($q) =>
            $q->when($tahun, fn($qq) => $qq->whereYear('tanggal_mulai', $tahun))
        ])
            ->orderByDesc('pengenaan_sp_count')
            ->get();

        $top_pelaku = PelakuUsaha::withCount([
            'pengenaan_sp as total_sanksi' => fn($q) =>
            $q->when(
                $tahun,
                fn($qq) =>
                $qq->whereYear('tanggal_mulai', $tahun)
            ),
            'pengenaan_sp as sudah_ditanggapi' => fn($q) =>
            $q->where('status_surat', 'sudah_ditanggapi')
                ->when(
                    $tahun,
                    fn($qq) =>
                    $qq->whereYear('tanggal_mulai', $tahun)
                ),
            'pengenaan_sp as belum_ditanggapi' => fn($q) =>
            $q->where('status_surat', 'belum_ditanggapi')
                ->when(
                    $tahun,
                    fn($qq) =>
                    $qq->whereYear('tanggal_mulai', $tahun)
                )
        ])
            ->orderByDesc('total_sanksi')
            ->limit(10)
            ->get();

        $top_jenis_pelaku_bar = JenisPelakuUsaha::withCount([
            'pengenaan_sp as total_sanksi' => fn($q) =>
            $q->when(
                $tahun,
                fn($qq) =>
                $qq->whereYear('tanggal_mulai', $tahun)
            ),
            'pengenaan_sp as sudah_ditanggapi' => fn($q) =>
            $q->where('status_surat', 'sudah_ditanggapi')
                ->when(
                    $tahun,
                    fn($qq) =>
                    $qq->whereYear('tanggal_mulai', $tahun)
                ),
            'pengenaan_sp as belum_ditanggapi' => fn($q) =>
            $q->where('status_surat', 'belum_ditanggapi')
                ->when(
                    $tahun,
                    fn($qq) =>
                    $qq->whereYear('tanggal_mulai', $tahun)
                )
        ])
            ->orderByDesc('total_sanksi')
            ->limit(10)
            ->get();

        $total_sanksi = $top_jenis_pelaku->sum('total_sanksi');

        $tahunList = PengenaanSP::selectRaw('YEAR(tanggal_mulai) as tahun')
            ->groupBy('tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('dashboard', [
            'title' => 'Dashboard',
            'pie_data' => [$belum, $selesai],
            'labels' => $labels_bar,
            'sudah'  => $sudah_bar,
            'belum'  => $belum_bar,
            'total_bar' => $total_bar,
            'top_pelaku' => $top_pelaku,
            'top_jenis_pelaku' => $top_jenis_pelaku,
            'sanksi_per_periode' => $sanksi_per_periode,
            'total_sanksi' => $total_sanksi,
            'sanksi_per_pelanggaran' => $sanksi_per_pelanggaran,
            'sanksi_per_bentuk' => $sanksi_per_bentuk,
            'top_jenis_pelaku_bar' => $top_jenis_pelaku_bar,
            'tahun_list' => $tahunList
        ]);
    }

    public function chartData(Request $request)
    {
        $group = $request->group_by;
        $showAll = $request->show_all == 1;

        $map = [
            'jenis_pelanggaran' => [
                'table' => 'jenis_pelanggaran',
                'label' => 'jenis_pelanggaran.nama',
                'fk'    => 'pengenaan_sp.jenis_pelanggaran_id'
            ],
            'sanksi' => [
                'table' => 'sanksi',
                'label' => 'sanksi.nama',
                'fk'    => 'pengenaan_sp.sanksi_id'
            ],
            'jenis_pelaku_usaha' => [
                'table' => 'jenis_pelaku_usaha',
                'label' => 'jenis_pelaku_usaha.nama',
                'fk'    => 'pengenaan_sp.jenis_pelaku_usaha_id'
            ],
            'pelaku_usaha' => [
                'table' => 'pelaku_usaha',
                'label' => 'pelaku_usaha.nama',
                'fk'    => 'pengenaan_sp.pelaku_usaha_id'
            ],
            'kategori_sp' => [
                'table' => 'kategori_sp',
                'label' => 'kategori_sp.nama',
                'fk'    => 'pengenaan_sp.kategori_sp_id'
            ],
        ];

        $cfg = $map[$group];

        $query = DB::table($cfg['table'])
            ->select(
                DB::raw($cfg['label'] . ' as label'),
                DB::raw("COALESCE(SUM(pengenaan_sp.status_surat = 'sudah_ditanggapi'),0) as sudah"),
                DB::raw("COALESCE(SUM(pengenaan_sp.status_surat = 'belum_ditanggapi'),0) as belum")
            )
            ->leftJoin(
                'pengenaan_sp',
                $cfg['fk'],
                '=',
                $cfg['table'] . '.id'
            )
            ->groupBy('label');

        if (!$showAll) {
            $query->havingRaw('sudah > 0 OR belum > 0');
        }

        $data = $query->get();

        return response()->json([
            'labels' => $data->pluck('label'),
            'sudah'  => $data->pluck('sudah'),
            'belum'  => $data->pluck('belum'),
        ]);
    }
}
