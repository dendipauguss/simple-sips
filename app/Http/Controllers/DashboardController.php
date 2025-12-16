<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengenaanSP;
use App\Models\JenisPelanggaran;
use Illuminate\Support\Facades\DB;

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

        return view('dashboard', [
            'title' => 'Dashboard',
            'pie_data' => [$belum, $selesai],
            'labels' => $labels_bar,
            'sudah'  => $sudah_bar,
            'belum'  => $belum_bar,
        ]);
    }

    public function chartData(Request $request)
    {
        $group = $request->group_by;

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

        if (!isset($map[$group])) {
            return response()->json([], 400);
        }

        $config = $map[$group];

        $data = DB::table('pengenaan_sp')
            ->join($config['table'], $config['fk'], '=', $config['table'] . '.id')
            ->select(
                DB::raw($config['label'] . ' as label'),
                DB::raw("SUM(status_surat = 'sudah_ditanggapi') as sudah"),
                DB::raw("SUM(status_surat = 'belum_ditanggapi') as belum")
            )
            ->groupBy('label')
            ->get();

        return response()->json([
            'labels' => $data->pluck('label'),
            'sudah'  => $data->pluck('sudah'),
            'belum'  => $data->pluck('belum'),
        ]);
    }
}
