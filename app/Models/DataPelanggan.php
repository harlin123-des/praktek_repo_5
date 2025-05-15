<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPelanggan extends Model
{
    use HasFactory;

    protected $table = 'data_pelanggan';

    protected $primaryKey = 'id_pelanggan'; // 🔹 Menentukan primary key yang benar
    public $incrementing = true; // 🔹 Jika ID auto-increment, biarkan true
    protected $keyType = 'int'; // 🔹 Tentukan tipe datanya

    protected $fillable = [
        'nama_pelanggan',
    ];
}
