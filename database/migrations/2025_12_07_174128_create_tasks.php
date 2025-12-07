<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // relasi ke project
            $table->foreignId('project_id')->constrained()->onDelete('cascade');

            // untuk subtask
            $table->foreignId('parent_id')->nullable()->constrained('tasks')->onDelete('cascade');

            $table->string('title');
            $table->text('description')->nullable();

            // tanggal task
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // progress otomatis
            $table->integer('progress')->default(0);
            $table->boolean('is_done')->default(false);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
