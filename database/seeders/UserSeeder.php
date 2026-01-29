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
            'password' => Hash::make('Dendipauguss_0'),
            'role' => 'admin'
        ]);

        User::create([
            'nama' => 'Dendi Paugus Sukmaya',
            'email' => 'dendipauguss00@gmail.com',
            'username' => 'dendipauguss00',
            'password' => Hash::make('Dendipauguss_00'),
            'role' => 'ketua_tim'
        ]);

        User::create([
            'nama' => 'Dendi Paugus Sukmaya',
            'email' => 'dendipauguss000@gmail.com',
            'username' => 'dendipauguss000',
            'password' => Hash::make('Dendipauguss_000'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Amser Irawan Panjaitan',
            'email' => 'amserirawanpanjaitan@gmail.com',
            'username' => 'amserirawanpanjaitan',
            'password' => Hash::make('Amserirawanpanjaitan_1'),
            'role' => 'ketua_tim'
        ]);

        User::create([
            'nama' => 'Agus Sulistiyanto',
            'email' => 'agussulistiyanto@gmail.com',
            'username' => 'agussulistiyanto',
            'password' => Hash::make('Agussulistiyanto_2'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Bernard Asido',
            'email' => 'bernardasido@gmail.com',
            'username' => 'bernardasido',
            'password' => Hash::make('Bernardasido_3'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Pirdaus Sabana',
            'email' => 'pirdaussabana@gmail.com',
            'username' => 'pirdaussabana',
            'password' => Hash::make('Pirdaussabana_4'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Chandra Fredrik Purba',
            'email' => 'chandrafredrikpurba@gmail.com',
            'username' => 'chandrafredrikpurba',
            'password' => Hash::make('Chandrafredrikpurba_5'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Tito Yassin',
            'email' => 'titoyassin@gmail.com',
            'username' => 'titoyassin',
            'password' => Hash::make('Titoyassin_6'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Rendy Cisara Sandy',
            'email' => 'rendycisarasandy@gmail.com',
            'username' => 'rendycisarasandy',
            'password' => Hash::make('Rendycisarasandy_7'),
            'role' => 'pegawai'
        ]);

        User::create([
            'nama' => 'Aulia Puspa Ramadhani',
            'email' => 'auliapusparamadhani@gmail.com',
            'username' => 'auliapusparamadhani',
            'password' => Hash::make('AuliaPuspaRamadhani_8'),
            'role' => 'pegawai'
        ]);
    }
}
