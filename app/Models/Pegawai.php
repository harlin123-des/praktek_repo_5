<?php

// app/Models/Pegawai.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'id', // pastikan id bisa diisi secara manual


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'id'; // Nama kolom primary key
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Tipe data primary key adalah string

    protected $fillable = [
        'id',

        'nama',
        'jenis_kelamin',
        'no_hp',
        'posisi',
        'shift',
        'tanggal_masuk',
        'status_karyawan',
        'userId',
    ];

    // Jika kamu menggunakan primary key string, tambahkan ini
    protected $keyType = 'string';
    public $incrementing = false;


    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }


    // Fungsi untuk generate kode pegawai otomatis (format: PGW-0001)
    public static function generateKodePegawai(): string
    {
        $lastPegawai = self::orderBy('id', 'desc')->first();

        if (!$lastPegawai) {
            return 'PGW-0001';
        }

        $lastId = $lastPegawai->id; // contoh: PGW-0009
        $number = (int) substr($lastId, 4); // ambil angka dari posisi ke-4

        $nextNumber = $number + 1;

        return 'PGW-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);


    public static function getKodePegawai()
    {
        // Ambil kode pegawai terakhir dari kolom id
        $lastId = DB::table('pegawais')
            ->select('id')
            ->where('id', 'like', 'PGW%') // Pastikan hanya mengambil ID dengan format PGW
            ->orderBy('id', 'desc') // Urutkan dari yang terbesar
            ->value('id'); // Ambil nilai ID terakhir

        // Jika belum ada data, mulai dari PGW001
        if (!$lastId) {
            return 'PGW001';
        }

        // Ambil angka dari kode pegawai terakhir (contoh: PGW001 -> 1)
        $lastNumber = (int) substr($lastId, 3);

        // Tambahkan 1 untuk kode pegawai berikutnya
        $nextNumber = $lastNumber + 1;

        // Format kode pegawai baru (contoh: 2 -> PGW002)
        $kodePegawai = 'PGW' . str_pad($nextNumber, 3, "0", STR_PAD_LEFT);

        return $kodePegawai;
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'pegawai_id');

    }
}
