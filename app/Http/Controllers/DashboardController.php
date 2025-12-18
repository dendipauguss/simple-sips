<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengenaanSP;
use App\Models\JenisPelanggaran;
use Illuminate\Support\Facades\DB;
use App\Models\PelakuUsaha;

class DashboardController extends Controller
{
    public function index()
    {
        $jenis = JenisPelanggaran::all();

        $labels_bar = [];
        $sudah_bar = [];
        $belum_bar = [];

        foreach ($jenis as $jp) {
            $labels_bar[] = $jp->nama;

            $sudah_bar[] = PengenaanSP::where('jenis_pelanggaran_id', $jp->id)
                ->where('status_surat', 'sudah_ditanggapi')
                ->count();

            $belum_bar[] = PengenaanSP::where('jenis_pelanggaran_id', $jp->id)
                ->where('status_surat', 'belum_ditanggapi')
                ->count();
        }

        $belum = PengenaanSP::where('status_surat', 'belum_ditanggapi')->count();
        $selesai = PengenaanSP::where('status_surat', 'sudah_ditanggapi')->count();

        $topPelaku = PelakuUsaha::withCount([
            'pengenaan_sp as total_sanksi',
            'pengenaan_sp as sudah_ditanggapi' => function ($query) {
                $query->where('status_surat', 'sudah_ditanggapi');
            },
            'pengenaan_sp as belum_ditanggapi' => function ($query) {
                $query->where('status_surat', 'belum_ditanggapi');
            },
        ])
            ->orderByDesc('total_sanksi')
            ->limit(5)
            ->get();

        //     $sanksi_per_periode = DB::table('pengenaan_sp')
        //         ->selectRaw("
        //     DATE_FORMAT(tanggal_mulai, '%b %Y') as periode,
        //     SUM(CASE WHEN status_surat = 'sudah_ditanggapi' THEN 1 ELSE 0 END) as sudah,
        //     SUM(CASE WHEN status_surat = 'belum_ditanggapi' THEN 1 ELSE 0 END) as belum,
        //     COUNT(*) as total
        // ")
        //         ->whereNotNull('tanggal_mulai')
        //         ->groupByRaw("YEAR(tanggal_mulai), MONTH(tanggal_mulai)")
        //         ->orderByRaw("YEAR(tanggal_mulai), MONTH(tanggal_mulai)")
        //         ->get();

        $sanksi_per_periode = DB::table('pengenaan_sp')
            ->select(
                'tanggal_mulai',
                DB::raw("SUM(status_surat = 'sudah_ditanggapi') as sudah"),
                DB::raw("SUM(status_surat = 'belum_ditanggapi') as belum")
            )
            ->groupBy('tanggal_mulai')
            ->orderBy('tanggal_mulai')
            ->get();

        return view('dashboard', [
            'title' => 'Dashboard',
            'pie_data' => [$belum, $selesai],
            'labels' => $labels_bar,
            'sudah'  => $sudah_bar,
            'belum'  => $belum_bar,
            'topPelaku' => $topPelaku,
            'sanksi_per_periode' => $sanksi_per_periode
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
