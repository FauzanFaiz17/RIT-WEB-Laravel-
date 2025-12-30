<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategori_keuangans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori'); // Contoh: "Konsumsi", "Transport"
            $table->enum('jenis_transaksi', ['masuk', 'keluar', 'all'])->default('all');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_keuangans');
    }
};
