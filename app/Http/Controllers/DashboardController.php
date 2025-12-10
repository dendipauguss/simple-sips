<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengenaanSP;

class DashboardController extends Controller
{
    public function index()
    {
        $belum = PengenaanSP::where('status_surat', 'belum_ditanggapi')->count();
        $selesai = PengenaanSP::where('status_surat', 'sudah_ditanggapi')->count();
        return view('dashboard', [
            'title' => 'Dashboard',
            'status_data' => [$belum, $selesai]
        ]);
    }
}
