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
        Schema::table('activities', function (Blueprint $table) {
            // Kita tambahkan kolom ENUM 'status' dengan default 'pending'
            // Kita taruh posisinya setelah kolom 'type' (atau 'description' jika type belum ada)
            $table->enum('status', ['pending', 'progress', 'completed'])
                  ->default('pending')
                  ->after('title'); // Sesuaikan 'after' dengan kolom terakhir di DB Anda
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
