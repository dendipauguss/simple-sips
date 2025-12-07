<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengenaanSanksi;

class DashboardController extends Controller
{
    public function index()
    {
        $belum = PengenaanSanksi::where('status', 'belum')->count();
        $pending = PengenaanSanksi::where('status', 'pending')->count();
        $selesai = PengenaanSanksi::where('status', 'selesai')->count();
        return view('dashboard', [
            'title' => 'Dashboard',
            'status_data' => [$belum, $pending, $selesai]
        ]);
    }
}
