<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class KategoriMenu extends Model
{
    use HasFactory;
    protected $table = 'kategori_menus'; 
    protected $primaryKey = 'id_kategori'; // Tetapkan primary key
    public $incrementing = false; // Matikan auto-increment
    protected $keyType = 'string'; // Gunakan STRING sebagai tipe primary key

    protected $fillable = ['id_kategori', 'nama_kategori', 'keterangan'];

    protected $guarded = [];

    public static function getKodeKategori()
    {
        // Query kode kategori
        $sql = "SELECT IFNULL(MAX(id_kategori), 'KAT000') as kode_kategori FROM kategori_menus";
        
        $kodeKategori = DB::select($sql);
        
        // Cacah hasilnya
        foreach ($kodeKategori as $kdktg) {
            $kd = $kdktg->kode_kategori;
        }

        // Mengambil substring 3 digit akhir dari string KAT000
        $noawal = substr($kd, 3);
        $noakhir = $noawal + 1; // Menambahkan 1, hasilnya adalah integer
        $noakhir = 'KAT' . str_pad($noakhir, 3, "0", STR_PAD_LEFT); // Menyusun kembali kode kategori
        
        return $noakhir;
    }
}
