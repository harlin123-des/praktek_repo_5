<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'satuan',
        'stok',
    ];
    public function pembelianDetails()
{
    return $this->hasMany(PembelianDetail::class);
}

}
