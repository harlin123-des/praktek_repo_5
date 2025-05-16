<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id', 'bulan', 'tahun', 'gaji_pokok', 'tunjangan', 'potongan', 'total_gaji'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    protected static function booted()
    {
        static::creating(function ($penggajian) {
            $jumlahHadir = Presensi::where('pegawai_id', $penggajian->pegawai_id)
                ->whereMonth('tanggal', $penggajian->bulan)
                ->whereYear('tanggal', $penggajian->tahun)
                ->where('status', 'hadir')
                ->count();

            $gajiPerHari = $penggajian->gaji_pokok / 30;
            $penggajian->total_gaji = ($gajiPerHari * $jumlahHadir) + ($penggajian->tunjangan ?? 0) - ($penggajian->potongan ?? 0);
        });
    }
}
