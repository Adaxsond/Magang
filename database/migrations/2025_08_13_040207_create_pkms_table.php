<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // ..._create_pkms_table.php
public function up(): void
{
    Schema::create('pkms', function (Blueprint $table) {
        $table->id();
        $table->foreignId('dosen_id')->constrained()->onDelete('cascade');
        $table->string('jenis_pkm');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkms');
    }
};
