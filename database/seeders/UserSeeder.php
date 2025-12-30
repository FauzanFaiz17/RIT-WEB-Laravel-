<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Fauzan Faiz Al-ghifari',
                'email' => 'fauzan@example.com',
                'password' => Hash::make('password123'),
                'no_hp' => '085318339358',
                'tanggal_lahir' => '2004-07-17',
                'npm' => '24073122028',
                'prodi' => 'RPL',
                'semester' => '7',
                'foto_profil' => 'default.png',
            ],
            [
                'name' => 'Ayunda Nasywa Nurzakya Hermawan',
                'email' => 'ayunda@example.com',
                'password' => Hash::make('password123'),
                'no_hp' => '081320958734',
                'tanggal_lahir' => '2007-11-19',
                'npm' => '24073524023',
                'prodi' => 'RPL',
                'semester' => '3',
                'foto_profil' => 'default.png',
            ],
            [
                'name' => 'AHMAD BASIR',
                'email' => 'basir@example.com',
                'password' => Hash::make('password123'),
                'no_hp' => '081244323907',
                'tanggal_lahir' => '2005-08-06',
                'npm' => '24073123025',
                'prodi' => 'RPL',
                'semester' => '5',
                'foto_profil' => 'default.png',
            ],
            [
                'name' => '	ALIFIA AZZAHRA',
                'email' => 'alifia@example.com',
                'password' => Hash::make('password123'),
                'no_hp' => '087842320373',
                'tanggal_lahir' => '2006-10-30',
                'npm' => '24072124049',
                'prodi' => 'TI',
                'semester' => '3',
                'foto_profil' => 'default.png',
            ],
            [
                'name' => 'NABILA PUTRI SOFIA',
                'email' => 'nabila@example.com',
                'password' => Hash::make('password123'),
                'no_hp' => '087877429760',
                'tanggal_lahir' => '2004-04-08',
                'npm' => '24072124013',
                'prodi' => 'TI',
                'semester' => '3',
                'foto_profil' => 'default.png',
            ],
            [
                'name' => 'AGITSA MUTSLA NAZIHAH',
                'email' => 'agitsa@example.com',
                'password' => Hash::make('password123'),
                'no_hp' => '082118282629',
                'tanggal_lahir' => '2006-08-03',
                'npm' => '24072124018',
                'prodi' => 'TI',
                'semester' => '3',
                'foto_profil' => 'default.png',
            ],
            [
                'name' => 'ISTINAIL MA`RUPAH',
                'email' => 'istinail@example.com',
                'password' => Hash::make('password123'),
                'no_hp' => '083878866476',
                'tanggal_lahir' => '2006-07-23',
                'npm' => '24072524061',
                'prodi' => 'TI',
                'semester' => '3',
                'foto_profil' => 'default.png',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
