<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // app/Models/User.php

public function pegawai()
{
    return $this->hasOne(\App\Models\Pegawai::class, 'userId', 'id');

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'userId');
    }

}

    }

