<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $table = 'berita_acara';

    protected $fillable = [
        'Id_BarangKeluar',
        'Id_User',
        'Nama_PihakPeminjam',
        'Total_BarangDipinjam',
        'Catatan',
        'File_BeritaAcara',
        'File_SuratJalan',
        'Tanggal_Keluar',
        'Tanggal_kembali',
    ];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class, 'Id_User');
    }
    public function BarangKeluar()
    {
        return $this->belongsTo(BarangKeluar::class, 'Id_BarangKeluar');
    }
}
