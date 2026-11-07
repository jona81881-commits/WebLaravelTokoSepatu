<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();                          // id (primary key)
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->cascadeOnDelete();
            $table->foreignId('matakuliah_id')->constrained('matakuliah')->cascadeOnDelete();
            $table->unsignedTinyInteger('semester');
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
