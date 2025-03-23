<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // 🔹 Tambahkan ini

class MetodePembayaran extends Model
{
    use HasFactory;

    protected $table = 'metode_pembayaran';

    protected $fillable = [
        'id_pembayaran', 
        'nama_metode', // 🔹 Tambahkan ini juga kalau sebelumnya tidak ada
        'metode', 
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
