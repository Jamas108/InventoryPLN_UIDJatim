<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'Id_Role', 'Nama', 'Jenis_Kelamin', 'Tanggal_Lahir', 'No_Telepon', 'Alamat', 'Instansi', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function UsersRole()
    {
        return $this->hasMany(UserRole::class, 'Id_Role');
    }
}
