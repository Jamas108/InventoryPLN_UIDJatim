<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusReturBarang extends Model
{
    protected $table = 'status_retur_barang';

    protected $fillable = [
        'Nama_Status',
        'Deskripsi_Status_retur',
    ];

    public function returBarang()
    {
        return $this->hasMany(ReturBarang::class, 'Id_Status_Retur');
    }
}
