<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'kategori_barang';

    protected $fillable = [
        'Nama_Role_Users',
        'Deskripsi_Role_Users',
    ];

    public function Users()
    {
        return $this->hasMany(User::class, 'Id_Role');
    }

}
