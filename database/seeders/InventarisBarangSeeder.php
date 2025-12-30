<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventarisBarang;

class InventarisBarangSeeder extends Seeder
{
    public function run(): void
    {
        // Barang 1
        InventarisBarang::create([
            'nama_barang' => 'Laptop Inventaris Asus',
            'stok' => 1, // Ada 1 unit
            'lokasi' => 'Lemari Besi Sekretariat'
        ]);

        // Barang 2
        InventarisBarang::create([
            'nama_barang' => 'Spidol Boardmarker Hitam',
            'stok' => 10,
            'lokasi' => 'Laci Meja 1'
        ]);

        // Barang 3
        InventarisBarang::create([
            'nama_barang' => 'Proyektor Epson',
            'stok' => 1,
            'lokasi' => 'Lemari Kaca'
        ]);
    }
}