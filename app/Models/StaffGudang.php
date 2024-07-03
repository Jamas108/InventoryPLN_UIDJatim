<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffGudang extends Model
{
    protected $table = 'staff_gudang';

    protected $fillable = [
        'Nama_Petugas',
        'JenisKelamin_Petugas',
        'TanggalLahir_petugas',
        'NoTelepon_petugas',
        'Alamat_Petugas',
    ];

    protected $dates = [
        'TanggalLahir_petugas',
    ];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'Id_Petugas');
    }
}
