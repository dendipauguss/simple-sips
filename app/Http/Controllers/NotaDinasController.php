<?php

namespace App\Http\Controllers;

use App\Models\NotaDinas;
use Illuminate\Http\Request;

class NotaDinasController extends Controller
{
    public function index()
    {
        return view('nota_dinas.index', [
            'title' => 'Nota Dinas',
            'nota_dinas' => NotaDinas::with(['pengenaan_sp'])->latest()->get()
        ]);
    }
}
