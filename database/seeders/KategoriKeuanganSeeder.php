<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriKeuangan;

class KategoriKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Uang Kas', 'jenis_transaksi' => 'masuk'],
            ['nama_kategori' => 'Dana Usaha (Danus)', 'jenis_transaksi' => 'masuk'],
            ['nama_kategori' => 'Konsumsi Rapat', 'jenis_transaksi' => 'keluar'],
            ['nama_kategori' => 'Transportasi', 'jenis_transaksi' => 'keluar'],
            ['nama_kategori' => 'Cetak Dokumen', 'jenis_transaksi' => 'keluar'],
            ['nama_kategori' => 'Sponsorship', 'jenis_transaksi' => 'masuk'],
        ];

        foreach ($data as $item) {
            KategoriKeuangan::create($item);
        }
    }
}