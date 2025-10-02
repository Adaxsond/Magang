<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // ..._create_pkm_luarans_table.php
public function up(): void
{
    Schema::create('pkm_luarans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pkm_id')->constrained()->onDelete('cascade');
        $table->enum('tipe', ['foto', 'jurnal']);
        $table->string('path_foto')->nullable();
        $table->string('nama_jurnal')->nullable();
        $table->year('tahun_rilis')->nullable();
        $table->string('link_jurnal')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkm_luarans');
    }
};
