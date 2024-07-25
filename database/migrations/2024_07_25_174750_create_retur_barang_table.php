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
        Schema::create('retur_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Id_User')->constrained('users_role');
            $table->foreignId('Id_BarangKeluar')->constrained('barang_keluar');
            $table->foreignId('Id_Status_Retur')->constrained('status_retur_barang');
            $table->foreignId('Id_Jenis_Retur')->constrained('jenis_retur_barang');
            $table->string('Pihak_Pemohon');
            $table->string('Nama_Barang');
            $table->string('Kode_Barang');
            $table->string('Kategori_Barang');
            $table->string('Jumlah Barang');
            $table->string('Deskripsi');
            $table->string('Foto_Barang');
            $table->string('Tanggal_Retur');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retur_barang');
    }
};
