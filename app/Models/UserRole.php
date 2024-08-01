<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'users_role';

    protected $fillable = [
        'Nama_Role_Users',
        'Deskripsi_Role_Users',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'Id_Role');
    }
}
