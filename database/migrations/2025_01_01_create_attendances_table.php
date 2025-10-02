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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('check_in_at')->nullable(); // Waktu Absen Masuk
            $table->dateTime('check_out_at')->nullable(); // Waktu Absen Pulang (Opsional)
            $table->string('location')->nullable(); // Lokasi absen (e.g., koordinat atau nama tempat)
            $table->string('photo_path')->nullable(); // Path foto saat absen
            $table->string('status')->default('Hadir'); // Status: Hadir, Sakit, Izin, Cuti
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};