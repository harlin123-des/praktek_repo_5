<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KategoriProduks extends Model

{
    use HasFactory;
    protected $table = 'kategori_produks';
    protected $guarded = [];
    public static function getKodeKategori(){
        // Query untuk mendapatkan kode kategori terakhir
        $sql = "SELECT IFNULL(MAX(kode_kategori), 'KTG000') as kode FROM kategori_produks";
        $kodeKategori = DB::select($sql);
        // Ambil hasil query
        foreach ($kodeKategori as $kd) {
            $kode = $kd->kode;
        }
        // Mengambil 3 digit terakhir dari kode kategori
        $noawal = substr($kode, -3);
        $noakhir = $noawal + 1;

        // Format kode baru (KTG diikuti angka 3 digit)
        $kodeBaru = 'KTG' . str_pad($noakhir, 3, "0", STR_PAD_LEFT);
        
        return $kodeBaru;

    }
}
