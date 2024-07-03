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
        Schema::create('staff_gudang', function (Blueprint $table) {
            $table->id();
            $table->string('Nama_Petugas', 255);
            $table->smallInteger('JenisKelamin_Petugas');
            $table->date('TanggalLahir_petugas');
            $table->char('NoTelepon_petugas', 12);
            $table->string('Alamat_Petugas', 256);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_gudang');
    }
};
