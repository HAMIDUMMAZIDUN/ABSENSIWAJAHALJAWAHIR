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
            // Menambahkan kolom 'phone' setelah kolom 'email'
            // Tipe data string (VARCHAR) adalah yang terbaik untuk no. telp
            // nullable() berarti boleh kosong (untuk user lama yang belum punya no. telp)
            // unique() memastikan tidak ada no. telp yang sama
            $table->string('phone')->nullable()->unique()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kode untuk menghapus kolom jika migrasi di-rollback
            $table->dropColumn('phone');
        });
    }
};