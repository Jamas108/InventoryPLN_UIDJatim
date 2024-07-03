<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    protected $table = 'kategori_barang';

    protected $fillable = [
        'Nama_Kategori_Barang',
        'Deskripsi_Kategori_Barang',
    ];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'Id_Kategori_Barang');
    }
}
