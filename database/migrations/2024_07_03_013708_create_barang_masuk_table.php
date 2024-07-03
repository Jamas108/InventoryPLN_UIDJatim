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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Id_Petugas')->constrained('staff_gudang');
            $table->string('No_Surat', 70);
            $table->string('NamaPerusahaan_Pengirim', 200);
            $table->date('TanggalPengiriman_Barang');
            $table->char('Jumlah_barang', 70);
            $table->string('File_SuratJalan', 200);
            $table->string('Kode_Barang', 200);
            $table->string('Nama_Barang', 200);
            $table->char('Jenis_Barang', 50);
            $table->foreignId('Id_Kategori_Barang')->constrained('kategori_barang');
            $table->integer('JumlahBarang_Masuk');
            $table->integer('Garansi_Barang');
            $table->char('Kondisi_Barang', 200);
            $table->date('Tanggal_Masuk');
            $table->string('Gambar_Barang');
            $table->foreignId('Id_Status_Barang')->constrained('status_barang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
