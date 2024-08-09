<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';

    protected $fillable = [
        'Id_Petugas',
        'No_Surat',
        'NamaPerusahaan_Pengirim',
        'TanggalPengiriman_Barang',
        'Jumlah_barang',
        'File_SuratJalan',
        'Kode_Barang',
        'Nama_Barang',
        'Jenis_Barang',
        'Id_Kategori_Barang',
        'JumlahBarang_Masuk',
        'Garansi_Barang',
        'Kondisi_Barang',
        'Tanggal_Masuk',
        'Gambar_Barang',
        'Id_Status_Barang',
    ];

    protected $dates = [
        'TanggalPengiriman_Barang',
        'Tanggal_Masuk',
    ];

    public function staffGudang()
    {
        return $this->belongsTo(StaffGudang::class, 'Id_Petugas');
    }

    public function kategoriBarang()
    {
        return $this->belongsTo(KategoriBarang::class, 'Id_Kategori_Barang');
    }
    protected $attributes = [
        'Id_Status_Barang' => 2, // Asumsikan 1 adalah ID untuk status "Pending"
    ];

    public function statusBarang()
    {
        return $this->belongsTo(StatusBarang::class, 'Id_Status_Barang');
    }
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'Kode_Barang', 'Kode_Barang');
    }
}
