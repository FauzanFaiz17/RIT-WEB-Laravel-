<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Surat;
use App\Models\User;

class SuratSeeder extends Seeder
{
    public function run(): void
    {
        $sekretaris = User::where('email', 'sekretaris@gmail.com')->first();

        // 1. Surat Masuk
        $suratMasuk = Surat::create([
            'nomor_surat' => '005/UND/EXT/X/2025',
            'tipe_surat' => 1, // Masuk
            'perihal' => 'Undangan Seminar Nasional',
            'asal_tujuan' => 'BEM Fakultas Teknik',
            'tanggal' => now()->subWeek(),
            'ringkasan' => 'Undangan delegasi 2 orang'
        ]);

        // Attach Bukti Scan
        $suratMasuk->buktis()->create([
            'file_path' => 'dummy/scan_surat_undangan.pdf'
        ]);

        // 2. Surat Keluar
        $suratKeluar = Surat::create([
            'nomor_surat' => '001/ORG/INT/XI/2025',
            'tipe_surat' => 2, // Keluar
            'perihal' => 'Permohonan Peminjaman Gedung',
            'asal_tujuan' => 'Bagian Umum Kampus',
            'tanggal' => now(),
            'ringkasan' => 'Untuk acara Makrab'
        ]);
        
        // Attach Bukti Arsip
        $suratKeluar->buktis()->create([
            'file_path' => 'dummy/arsip_surat_peminjaman.pdf'
        ]);
    }
}