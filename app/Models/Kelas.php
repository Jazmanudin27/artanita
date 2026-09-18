<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Kelas extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "kelas";
    protected $primaryKey = "kode_kelas";

    protected $fillable = [
        'nama_kelas',
        'jurusan',
        'kode_guru',
        'kode_member',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

