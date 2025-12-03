<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penindakan;

class DashboardController extends Controller
{
    public function index()
    {
        $belum = Penindakan::where('status', 'belum')->count();
        $pending = Penindakan::where('status', 'pending')->count();
        $selesai = Penindakan::where('status', 'selesai')->count();
        return view('dashboard', [
            'title' => 'Dashboard',
            'status_data' => [$belum, $pending, $selesai]
        ]);
    }
}
