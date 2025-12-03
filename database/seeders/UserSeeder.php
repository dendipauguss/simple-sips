<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('password_admin'),
            'role' => 'admin'
        ]);

        User::create([
            'nama' => 'Pegawai 1',
            'email' => 'pegawai1@gmail.com',
            'username' => 'pegawai1',
            'password' => Hash::make('password_pegawai'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Pegawai 2',
            'email' => 'pegawai2@gmail.com',
            'username' => 'pegawai2',
            'password' => Hash::make('password_pegawai'),
            'role' => 'pegawai'
        ]);
    }
}
