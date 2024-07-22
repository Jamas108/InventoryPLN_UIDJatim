<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPeminjaman extends Model
{
    protected $table = 'kategori_peminjaman';

    protected $fillable = [
        'Nama_Kategori_Peminjaman',
        'Deskripsi_Kategori_Peminjaman',
    ];

    public function barangKeluar()
    {
        return $this->hasMany(BarangMasuk::class, 'Id_Kategori_Peminjaman');
    }
}
