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
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_keuangan_id')->constrained('kategori_keuangans');
            
            $table->string('uraian'); 
            $table->tinyInteger('jenis'); // 1=Masuk, 2=Keluar
            $table->decimal('nominal', 15, 2); 
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
        Schema::dropIfExists('keuangans');
    }
};
