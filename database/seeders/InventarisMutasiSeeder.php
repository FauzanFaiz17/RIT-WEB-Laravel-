<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventarisMutasi;
use App\Models\InventarisBarang;
use App\Models\User;

class InventarisMutasiSeeder extends Seeder
{
    public function run(): void
    {
        $spidol = InventarisBarang::where('nama_barang', 'LIKE', '%Spidol%')->first();

        // Skenario: Ambil 2 Spidol
        InventarisMutasi::create([
            'barang_id' => $spidol->id,
            'jenis_mutasi' => 'keluar',
            'jumlah' => 2,
            'sisa_stok_saat_ini' => 8, // (10 - 2 = 8) Manual hitung utk seeder
            'tanggal' => now(),
            'keterangan' => 'Dipakai Rapat Divisi Acara'
        ]);

        // Update stok master (biar sinkron saat dicek di DB)
        $spidol->update(['stok' => 8]);
    }
}