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
        Schema::create('inventaris_mutasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('inventaris_barangs')->onDelete('cascade');

            $table->enum('jenis_mutasi', ['masuk', 'keluar', 'rusak', 'hilang']);
            $table->integer('jumlah');
            $table->integer('sisa_stok_saat_ini'); // Snapshot history
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_mutasis');
    }
};
