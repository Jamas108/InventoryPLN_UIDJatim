<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisReturBarang extends Model
{
    protected $table = 'jenis_retur_barang';

    protected $fillable = [
        'Jenis_Retur',
        'Deskripsi_Jenis_Retur',
    ];

    public function returBarang()
    {
        return $this->hasMany(ReturBarang::class, 'Id_Jenis_Retur');
    }
}
