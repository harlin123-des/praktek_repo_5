<?php
// app/Models/Pegawai.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'id', // pastikan id bisa diisi secara manual
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
    }
}
