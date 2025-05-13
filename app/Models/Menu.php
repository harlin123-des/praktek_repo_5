<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// tambahan
use Illuminate\Support\Facades\DB; 

class Menu extends Model 
{
    use HasFactory; 
    protected $table = 'menu'; 

    protected $guarded = []; 

    public static function getIdMenu() //Fungsi ini digunakan untuk menghasilkan ID menu baru secara otomatis berdasarkan ID terakhir dalam database.
    {
        // query kode perusahaan
        $sql = "SELECT IFNULL(MAX(id_menu), 'DM000') as id_menu 
                FROM menu "; //Digunakan untuk membantu penomoran otomatis ketika menambahkan data baru.
        $idmenu = DB::select($sql); //Menjalankan query SQL menggunakan Query Builder Laravel.

        // cacah hasilnya
        foreach ($idmenu as $idmnu) { // ini digunakan untuk mengambil data dari hasil query SQL yang sebelumnya dijalankan.
            $kd = $idmnu->id_menu; //Kode ini digunakan untuk mengambil nilai id_menu dari hasil query yang tersimpan dalam variabel $idmenu.
        }
        
        $noawal = substr($kd,-3); //mengambil tiga digit terakhir dari variabel $kd
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        $noakhir = 'DM'.str_pad($noakhir,3,"0",STR_PAD_LEFT); //menyambung dengan string DM-001. menambahkan nol di depan supaya tetap 3 digit
        return $noakhir;// Mengembalikan ID baru yang sudah di-generate

    }

    // Dengan mutator ini, setiap kali data harga_menu dikirim ke database, koma akan otomatis dihapus.
    public function setHargaMenuAttribute($value)
    {
        // Hapus koma (,) dari nilai sebelum menyimpannya ke database
        $this->attributes['harga_menu'] = str_replace('.', '', $value);
    }
    // Relasi dengan tabel relasi many to many nya
    public function penjualanMenu()
    {
        return $this->hasMany(PenjualanMenu::class, 'menu_id');
    }
}
