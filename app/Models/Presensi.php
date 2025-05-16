<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $fillable = [
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan',
        'pegawai_id',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
