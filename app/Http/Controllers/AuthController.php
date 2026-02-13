<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Google\Client as GoogleClient;
use App\Models\HistoriLogin;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login', [
            'title' => 'Login',
            'histori_login' => HistoriLogin::latest('last_login_at')
                ->limit(3)
                ->get()
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

            // HistoriLogin::updateOrCreate(
            //     ['user_id' => Auth::id()],
            //     [
            //         'email' => Auth::user()->email,
            //         'name' => Auth::user()->nama,
            //         'provider' => 'password',
            //         'last_login_at' => now()
            //     ]
            // );

            return redirect()->route('dashboard')->with('info', 'Selamat Datang ' . Auth::user()->nama);
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

    public function login_with_google(Request $request)
    {
        $request->validate([
            'credential' => 'required'
        ]);

        $client = new GoogleClient([
            'client_id' => env('GOOGLE_AUTH_CLIENT_ID')
        ]);

        try {
            $payload = $client->verifyIdToken($request->credential);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Token Google tidak valid'
            ], 401);
        }

        if (!$payload) {
            return response()->json([
                'message' => 'Token Google tidak valid'
            ], 401);
        }

        $email = $payload['email'];
        $googleId = $payload['sub'];

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Akun tidak terdaftar'
            ], 403);
        }

        // simpan google_id jika belum ada
        if (!$user->google_id) {
            $user->update([
                'google_id' => $googleId
            ]);
        }

        Auth::login($user);

        // HistoriLogin::updateOrCreate(
        //     ['user_id' => $user->id],
        //     [
        //         'email' => $user->email,
        //         'name' => $user->nama,
        //         'provider' => 'google',
        //         'last_login_at' => now()
        //     ]
        // );

        session()->flash('info', 'Selamat Datang ' . $user->nama);

        return response()->json([
            'success' => true,
            'redirect' => url('/dashboard')
        ]);
    }
}
