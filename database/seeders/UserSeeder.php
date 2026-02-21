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
            'nama' => 'Dendi Paugus Sukmaya',
            'email' => 'dendipauguss0@gmail.com',
            'username' => 'dendipauguss0',
            'password' => Hash::make('D3nd!p4u9u55_0'),
            'role' => 'admin'
        ]);

        User::create([
            'nama' => 'Dendi Paugus Sukmaya',
            'email' => 'dendipauguss00@gmail.com',
            'username' => 'dendipauguss00',
            'password' => Hash::make('D3nd!p4u9u55_00'),
            'role' => 'ketua_tim'
        ]);

        User::create([
            'nama' => 'Dendi Paugus Sukmaya',
            'email' => 'dendipauguss1111@gmail.com',
            'username' => 'dendipauguss',
            'password' => Hash::make('D3nd!p4u9u55_11'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Amser Irawan Panjaitan',
            'email' => 'amserpanjaitan@gmail.com',
            'username' => 'amserirawanpanjaitan',
            'password' => Hash::make('Amser#irawan#panjaitan_1'),
            'role' => 'ketua_tim'
        ]);

        User::create([
            'nama' => 'Bernard Asido',
            'email' => 'bernardasido24@gmail.com',
            'username' => 'bernardasido',
            'password' => Hash::make('Bernard#asido_3'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Pirdaus Sabana',
            'email' => 'firdaus.sabana@gmail.com',
            'username' => 'pirdaussabana',
            'password' => Hash::make('Pirdaus#sabana_4'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Tito Yassin',
            'email' => 'tito.yassin1991@gmail.com',
            'username' => 'titoyassin',
            'password' => Hash::make('Tito#yassin_5'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Rendy Cisara Sandy',
            'email' => 'Rendysandy04@gmail.com',
            'username' => 'rendycisarasandy',
            'password' => Hash::make('Rendy#cisara#sandy_6'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Aulia Puspa Ramadhani',
            'email' => 'r.auliapuspa@gmail.com',
            'username' => 'auliapusparamadhani',
            'password' => Hash::make('Aulia#puspa#ramadhani_7'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Rorundak 2',
            'email' => 'rorundak.2@gmail.com',
            'username' => 'rorundak2',
            'password' => Hash::make('Rorundak#2_2')
        ]);
    }
}
