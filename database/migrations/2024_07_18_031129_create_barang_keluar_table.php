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
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Id_Peminjam')->constrained('users_role');
            $table->foreignId('Id_Kategori_Peminjaman')->constrained('kategori_peminjaman');
            $table->foreignId('Id_StatusBarangKeluar')->constrained('status_barang_keluar');
            $table->string('Kode_BarangKeluar');
            $table->string('Nama_BarangKeluar');
            $table->string('Jumlah_BarangKeluar');
            $table->string('Tanggal_BarangKeluar');
            $table->string('Tanggal_PengembalianBarang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
