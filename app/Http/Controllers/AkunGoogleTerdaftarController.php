<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkunGoogleTerdaftar;

class AkunGoogleTerdaftarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:allowed_google_accounts,email',
            'role'  => 'required',
        ]);

        AkunGoogleTerdaftar::create([
            'email' => $request->email,
            'role'  => $request->role,
            'is_active' => true,
        ]);

        return back()->with('success', 'Akun Google berhasil ditambahkan');
    }
}
