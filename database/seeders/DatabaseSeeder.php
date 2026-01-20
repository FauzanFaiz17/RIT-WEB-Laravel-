<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder lain
        $this->call([
            MenuSeeder::class, 
            MenuItemSeeder::class, 
            RoleSeeder::class, 
            UnitSeeder::class, 
            RoleSeeder::class, 
            UnitSeeder::class, 
            RoleSeeder::class, 
            UnitSeeder::class, 
            RoleSeeder::class, 
            UnitSeeder::class, 
            UserSeeder::class,
            KategoriKeuanganSeeder::class,
            InventarisBarangSeeder::class,        
            KeuanganSeeder::class,
            SuratSeeder::class,
            InventarisMutasiSeeder::class,
            ProjectSeeder::class,
            TaskSeeder::class,
            ]);
    }
}
