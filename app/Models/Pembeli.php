<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    use HasFactory;

    // Tentukan nama tabel dan primary key
    protected $table = 'data_pelanggan';  // Pastikan sesuai dengan nama tabel di database
    protected $primaryKey = 'pembeli_id'; // Ganti 'pembeli_id' dengan kolom primary key yang benar

    protected $fillable = ['nama_pelanggan'];  // Pastikan kolom yang benar ada di sini

    // Relasi dengan Penjualan
    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'pembeli_id');
    }
}
