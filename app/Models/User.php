<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'username',
        'password',
        'nik',
        'tanggal_lahir',
        'no_wa',
        'role',
        'bio'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function surats()
    {
        return $this->hasMany(Surat::class);
    }
}
