<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan'; // sesuaikan nama tabel

    protected $fillable = [
        'no_faktur',
        'nama_pembeli',
        'email',
        'jenis_penjualan',
        'status',
        'tgl',
        'tagihan',
        'user_id',
    ];

    public function penjualanMenu()
    {
        return $this->hasMany(PenjualanMenu::class, 'penjualan_id');
    }

    public static function getKodeFaktur()
    {
        $last = self::latest('id')->first();
        if (!$last) {
            return 'F-0000001';
        }

        $lastNo = intval(substr($last->no_faktur, 2));
        $nextNo = $lastNo + 1;
        return 'F-' . str_pad($nextNo, 7, '0', STR_PAD_LEFT);
    }
}
