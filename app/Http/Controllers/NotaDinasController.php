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
            'nota_dinas' => NotaDinas::with([
                'pengenaan_sp' => function ($q) {
                    $q->latest()->limit(5);
                }
            ])->get()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(NotaDinas $notaDinas)
    {
        //
    }

    public function edit(NotaDinas $notaDinas)
    {
        //
    }

    public function update(Request $request, NotaDinas $notaDinas)
    {
        //
    }

    public function destroy(NotaDinas $notaDinas)
    {
        //
    }
}
