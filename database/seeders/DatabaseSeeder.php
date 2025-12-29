<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(MenuSeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(KategoriKeuanganSeeder::class);
        $this->call(InventarisBarangSeeder::class);
        $this->call(KeuanganSeeder::class);
        $this->call(SuratSeeder::class);
        $this->call(InventarisMutasiSeeder::class);

        
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
