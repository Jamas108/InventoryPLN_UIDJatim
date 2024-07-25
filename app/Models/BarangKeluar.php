<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluar';

    protected $fillable = [
        'Id_User',
        'Id_Kategori_Peminjaman',
        'Id_barangKeluar',
        'Id_BeritaAcara',
        'Id_StatusBarangKeluar',
        'Kode_BarangKeluar',
        'Kode_Barang',
        'Nama_Barang',
        'Kategori_Barang',
        'Nama_PihakPeminjam',
        'Catatan',
        'No_SuratJalanBK',
        'File_BeritaAcara',
        'File_SuratJalan',
        'Jumlah_Barang',
        'Tanggal_BarangKeluar',
        'Tanggal_PengembalianBarang',
    ];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class, 'Id_User');
    }


    // Relationship with KategoriPeminjaman model
    public function kategoriPeminjaman()
    {
        return $this->belongsTo(KategoriPeminjaman::class, 'Id_Kategori_Peminjaman');
    }

    public function kategoriBarang()
    {
        return $this->belongsTo(KategoriBarang::class, 'Nama_Kategori_Barang');
    }
    public function barangMasuk()
    {
        return $this->belongsTo(BarangMasuk::class, 'Nama_Barang');
    }
    public function beritaAcara()
    {
        return $this->belongsTo(BeritaAcara::class, 'Id_BeritaAcara');
    }
}
