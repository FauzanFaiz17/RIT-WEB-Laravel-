<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keuangan;           // <--- PENTING
use App\Models\KategoriKeuangan;   // <--- PENTING, karena kita butuh ID-nya

class KeuanganSeeder extends Seeder
{
    public function run(): void
    {
        // 1
        $kategoriMasuk = KategoriKeuangan::where('jenis_transaksi', 'masuk')->first();
        
        $kategoriKeluar = KategoriKeuangan::where('jenis_transaksi', 'keluar')->first();

        if ($kategoriMasuk && $kategoriKeluar) {
            
            $data = [
                // CONTOH PEMASUKAN (Jenis = 1)
                [
                    'kategori_keuangan_id' => $kategoriMasuk->id,
                    'uraian'               => 'Setoran Iuran Bulan Desember',
                    'jenis'                => 1, // 1 = Masuk (Sesuai kesepakatan migrasi Anda)
                    'nominal'              => 500000.00,
                    'tanggal'              => '2025-12-01',
                    'keterangan'           => 'Diterima dari bendahara kelas'
                ],
                // CONTOH PENGELUARAN (Jenis = 2)
                [
                    'kategori_keuangan_id' => $kategoriKeluar->id,
                    'uraian'               => 'Beli Snack Rapat Evaluasi',
                    'jenis'                => 2, // 2 = Keluar
                    'nominal'              => 75000.00,
                    'tanggal'              => '2025-12-05',
                    'keterangan'           => 'Nasi uduk dan gorengan'
                ],
            ];

            foreach ($data as $item) {
                Keuangan::create($item);
            }
        }
    }
}