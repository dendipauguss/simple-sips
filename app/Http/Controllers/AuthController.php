<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login', [
            'title' => 'Login'
        ]);
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username_or_email'    => 'required|string',
            'password' => 'required',
        ], [
            'username_or_email.required' => 'Username/Email tidak boleh kosong kakak',
            'password.required' => 'Password tidak boleh kosong kakak',
        ]);

        $loginField = filter_var($request->username_or_email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginField => $request->username_or_email,
            'password'  => $request->password,
            'status' => 1
        ];

        if (Auth::attempt($credentials)) {
            // regenerate session
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username_or_email' => 'Username/Email atau password salah.',
        ]);
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'username'    => 'required|string|unique:users,username',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'username'    => $request->username,
            'password' => Hash::make($request->password),
        ]);

        // Login otomatis setelah register
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
