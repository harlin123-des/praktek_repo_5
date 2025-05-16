<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{

    protected $fillable = [

    use HasFactory;

    protected $table = 'presensis';

    protected $fillable = [
        'pegawai_id',

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

        return $this->belongsTo(Pegawai::class, 'pegawai_id');

    }
}
