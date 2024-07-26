<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturBarang extends Model
{
    use HasFactory;

    protected $table = 'retur_barang';

    protected $fillable = [
        'Id_Barang_Keluar',
        'Id_User',
        'Id_Status_Retur',
        'Id_Jenis_Retur',
        'Pihak_Pemohon',
        'Nama_Barang',
        'Kode_Barang',
        'Kategori_Barang',
        'Jumlah_Barang',
        'Deskripsi',
        'Gambar',
        'Tanggal_Retur',
    ];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class, 'Id_User');
    }

    // Relationship with KategoriPeminjaman model
    public function statusRetur()
    {
        return $this->belongsTo(StatusReturBarang::class, 'Id_Status-Retur');
    }

    public function jenisRetur()
    {
        return $this->belongsTo(JenisReturBarang::class, 'Id_Jenis_Retur');
    }
    public function barangKeluar()
    {
        return $this->belongsTo(BarangKeluar::class, 'Kode_Barang', 'Kode_Barang');
    }

    public function barangMasuk()
    {
        return $this->belongsTo(BarangMasuk::class, 'Kode_Barang', 'Kode_Barang');
    }

}
