<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusBarang extends Model
{
    protected $table = 'status_barang';

    protected $fillable = [
        'Nama_Status',
        'Deskripsi_Status_Barang',
    ];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'Id_Status_Barang');
    }
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'Id_Status_Barang');
    }
}
