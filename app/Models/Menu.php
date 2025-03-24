<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// tambahan
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'menu'; // Nama tabel eksplisit

    protected $guarded = [];

    public static function getIdMenu()
    {
        // query kode perusahaan
        $sql = "SELECT IFNULL(MAX(id_menu), 'DM000') as id_menu 
                FROM menu ";
        $idmenu = DB::select($sql);

        // cacah hasilnya
        foreach ($idmenu as $idmnu) {
            $kd = $idmnu->id_menu;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($kd,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        $noakhir = 'DM'.str_pad($noakhir,3,"0",STR_PAD_LEFT); //menyambung dengan string PR-001
        return $noakhir;

    }

    // Dengan mutator ini, setiap kali data harga_menu dikirim ke database, koma akan otomatis dihapus.
    public function setHargaMenuAttribute($value)
    {
        // Hapus koma (,) dari nilai sebelum menyimpannya ke database
        $this->attributes['harga_menu'] = str_replace('.', '', $value);
    }
}
