<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Menambahkan kolom 'role' setelah kolom 'email'
            // Defaultnya adalah 'admin' agar user yang sudah ada otomatis menjadi admin biasa
            $table->enum('role', ['superadmin', 'admin'])->default('admin')->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};