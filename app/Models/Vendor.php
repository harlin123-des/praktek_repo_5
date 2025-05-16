<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    // ✅ IZINKAN mass assignment
    protected $fillable = [
        'nama_vendor',
        'alamat',
        'no_telp',
    ];

    public function pembelian()
    {
        return $this->hasMany(PembelianBahanBaku::class);
    }
}
