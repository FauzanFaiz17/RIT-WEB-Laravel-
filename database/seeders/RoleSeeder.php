<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {

        $roles = [
            'Ketua',
            'Wakil Ketua',
            'Sekretaris',
            'Bendahara',
            'Kepala Komunitas',
            'Kepala Divisi',
            'Anggota',
        ];

       foreach ($roles as $roleName) {
        
        \App\Models\Role::updateOrCreate(
            ['name' => $roleName], // Cari apakah role ini sudah ada
            ['name' => $roleName]  // Jika sudah ada/belum, pastikan namanya ini
        );
    }
    }
}