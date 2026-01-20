<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // tambahkan kolom status dulu
            $table->enum('status', ['todo', 'in_progress', 'done'])
                  ->default('todo')
                  ->after('progress');
        });

        // migrasi data lama (jika ada)
        DB::table('tasks')->where('done', true)->update([
            'status' => 'done',
            'progress' => 100,
        ]);

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('done');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('done')->default(false)->after('progress');
        });

        DB::table('tasks')->where('status', 'done')->update([
            'done' => true,
        ]);

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
