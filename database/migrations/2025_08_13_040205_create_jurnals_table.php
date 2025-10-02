<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // ..._create_jurnals_table.php
public function up(): void
{
    Schema::create('jurnals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('dosen_id')->constrained()->onDelete('cascade'); // Terhubung ke tabel dosens
        $table->string('nama_jurnal');
        $table->year('tahun_rilis');
        $table->string('link_jurnal');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};
