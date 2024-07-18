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
        Schema::create('kategori_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('Nama_Kategori_Peminjaman', 200);
            $table->string('Deskripsi_Kategori_Peminjaman', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_peminjama');
    }
};
