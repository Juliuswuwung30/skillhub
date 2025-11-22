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
        Schema::create('pendaftaran_kelas', function (Blueprint $table) {
        $table->id();

        $table->foreignId('peserta_id')
        ->constrained('peserta')
        ->onDelete('cascade');

        $table->foreignId('kelas_id')
        ->constrained('kelas')
        ->onDelete('cascade');

    $table->timestamps();

        $table->unique(['peserta_id', 'kelas_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_kelas');
    }
};
