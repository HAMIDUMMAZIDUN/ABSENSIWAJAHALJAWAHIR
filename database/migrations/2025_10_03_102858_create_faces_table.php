<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faces', function (Blueprint $table) {
            // Kolom ID utama yang auto-increment
            $table->id();

            // Kolom Foreign Key untuk relasi ke tabel 'users'
            // onDelete('cascade') berarti jika user dihapus, data wajah ini juga akan terhapus.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Kolom untuk menyimpan path/lokasi file gambar wajah
            $table->string('face_image_path');

            // Kolom status untuk verifikasi, defaultnya adalah false (pending)
            $table->boolean('is_verified')->default(false);

            // Kolom 'created_at' dan 'updated_at' secara otomatis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faces');
    }
};
