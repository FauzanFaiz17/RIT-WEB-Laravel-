<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'tanggal_lahir' => '2000-01-01',
            'npm' => '12345678',
            'prodi' => 'TI',
            'semester' => 5,
            'foto_profil' => null,
        ]);

        User::create([
            'name' => 'User Demo',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '089876543210',
            'tanggal_lahir' => '2001-05-10',
            'npm' => '87654321',
            'prodi' => 'RPL',
            'semester' => 3,
            'foto_profil' => null,
        ]);
    }
}