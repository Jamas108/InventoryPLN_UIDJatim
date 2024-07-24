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
            Schema::create('berita_acara', function (Blueprint $table) {
                $table->id();
                $table->foreignId('Id_BarangKeluar')->constrained('barang_keluar');
                $table->foreign('Id_BarangKeluar')->references('Id')->on('barang_keluar')->onDelete('cascade');
                $table->foreignId('Id_User')->constrained('users_role');
                $table->string('Nama_PihakPeminjam');
                $table->string('Total_BarangDipinjam');
                $table->string('Catatan');
                $table->string('File_BeritaAcara');
                $table->string('File_SuratJalan');
                $table->string('Tanggal_Keluar');
                $table->string('Tanggal_Kembali');

                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('berita_acara');
        }
    };
