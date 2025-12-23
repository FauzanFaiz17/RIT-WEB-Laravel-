<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        // 1. KOMUNITAS
        $it = Unit::create([
            'name' => 'Komunitas IT',
            'description' => 'Wadah mahasiswa IT',
            'parent_id' => null,
        ]);

        $game = Unit::create([
            'name' => 'Komunitas Game',
            'description' => 'Wadah gamers',
            'parent_id' => null,
        ]);

        // 2. DIVISI KHUSUS IT
        $divisiIT = [
            'Web Developer',
            'RIOT',
            'Game Developer',
            'Cyber Security'
        ];

        foreach ($divisiIT as $divisi) {
            Unit::create(['name' => $divisi, 'parent_id' => $it->id]);
        }
    }
}