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
        $data = PengenaanSP::select(
            'jenis_pelanggaran_id',
            'jenis_pelaku_usaha_id',
            DB::raw('COUNT(*) as jumlah')
        )
            ->groupBy('jenis_pelanggaran_id', 'jenis_pelaku_usaha_id')
            ->get();

        // $barDataPelanggaran = [
        //     [
        //         "y" => "Bank",
        //         "a" => $sanksi_by_bank
        //     ],
        //     [
        //         "y" => "Bursa",
        //         "a" => $sanksi_by_bursa
        //     ],
        //     [
        //         "y" => "Kliring",
        //         "a" => $sanksi_by_kliring
        //     ],
        //     [
        //         "y" => "Pedagang",
        //         "a" => $sanksi_by_pedagang
        //     ],
        //     [
        //         "y" => "Emas",
        //         "a" => $sanksi_by_emas
        //     ],
        //     [
        //         "y" => "Timah",
        //         "a" => $sanksi_by_timah
        //     ],
        //     [
        //         "y" => "Pialang",
        //         "a" => $sanksi_by_pialang
        //     ],
        // ];

        $jenis_pelanggaran = JenisPelanggaran::all();

        $belum = PengenaanSP::where('status_surat', 'belum_ditanggapi')->count();
        $selesai = PengenaanSP::where('status_surat', 'sudah_ditanggapi')->count();
        return view('dashboard', [
            'title' => 'Dashboard',
            'pie_data' => [$belum, $selesai],
            // 'bar_data' => $barDataPelanggaran,
            'jenis_pelanggaran' => $jenis_pelanggaran
        ]);
    }
}
