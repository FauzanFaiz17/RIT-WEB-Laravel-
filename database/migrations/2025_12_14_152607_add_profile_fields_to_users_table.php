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
        Schema::table('users', function (Blueprint $table) {
                $table->string('no_hp')->nullable()->after('password');
                $table->date('tanggal_lahir')->nullable()->after('no_hp');
                $table->string('npm')->nullable()->after('tanggal_lahir');
                $table->enum('prodi', ['TI', 'RPL', 'RSK', 'ILKOM'])->nullable()->after('npm');
                $table->enum('semester', ['1','2','3','4','5','6','7','8','9','10','11','12'])
                ->nullable()->after('prodi');
                $table->string('foto_profil')->nullable()->after('semester');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
              $table->dropColumn([
                'no_hp',
                'tanggal_lahir',
                'npm',
                'prodi',
                'semester',
                'foto_profil',
            ]);
        });
    }
};
