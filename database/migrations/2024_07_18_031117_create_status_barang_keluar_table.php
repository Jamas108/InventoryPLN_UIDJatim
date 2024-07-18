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
        Schema::create('status_barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('Nama_Status_Barang_Keluar', 200);
            $table->string('Deskripsi_Status_Barang_Keluar', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_barang_keluar');
    }
};
