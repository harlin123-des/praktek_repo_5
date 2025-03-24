<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KategoriProdukz extends Model
{
    use HasFactory;
    protected $table = 'kategori_produkzs'; // Pastikan sesuai dengan nama tabel di database
    protected $guarded = [];

    // Tambahkan method ini
    public static function getKodeKategori()
    {
        $sql = "SELECT IFNULL(MAX(id), 'KAT000') as kode_kategori FROM kategori_produkzs";
        $kodeKategori = \DB::select($sql);

        foreach ($kodeKategori as $kdktg) {
            $kd = $kdktg->kode_kategori;
        }

        $noawal = substr($kd, 3);
        $noakhir = $noawal + 1;
        return 'KAT' . str_pad($noakhir, 3, "0", STR_PAD_LEFT);
    }
}
