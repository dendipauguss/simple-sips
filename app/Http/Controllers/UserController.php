<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'title' => 'Data User',
            'users' => User::latest()->get()
        ]);
    }

    public function create()
    {
        return view('users.create', [
            'title' => 'Tambah User'
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => [
                'required',
                'email',
                'regex:/@(gmail\.com|yahoo\.com|outlook\.com)$/i',
            ],
            'role' => ['required'],
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',      // huruf kecil
                'regex:/[A-Z]/',      // huruf besar
                'regex:/[0-9]/',      // angka
                'regex:/[\W_]/',      // simbol
            ],
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.max' => 'Maksimal 255 karakter',
            'username.required' => 'Username tidak boleh kosong',
            'username.max' => 'Maksimal 255 karakter',
            'username.unique' => 'Username telah dipakai',
            'email.required' => 'Email tidak boleh kosong',
            'email.regex' => 'Email harus menggunakan provider yang diperbolehkan.',
            'email.email' => 'Harus berupa email',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, kecil, angka, dan simbol.',
            'password.required' => 'Password tidak boleh kosong',
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'title' => 'Edit User',
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
            'password' => 'nullable|min:5',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
