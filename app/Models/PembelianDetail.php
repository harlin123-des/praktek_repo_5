<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;
    public function pembelian()
{
    return $this->belongsTo(PembelianBahanBaku::class, 'pembelian_id');
}

public function bahanBaku()
{
    return $this->belongsTo(BahanBaku::class);
}
protected $fillable = ['pembelian_id', 'bahan_baku_id', 'jumlah', 'harga_satuan'];

protected static function booted()
{
    static::created(function ($detail) {
        $bahanBaku = $detail->bahanBaku;

        // Tambahkan jumlah ke stok
        $bahanBaku->increment('stok', $detail->jumlah);
    });

    // Jika update / delete juga perlu diperhatikan, tambahkan logika tambahan
}

}
