<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coa extends Model
{
    protected $primaryKey = 'kode_akun';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_akun',         // <-- ini baris pentingnya
        'header_akun',
        'nama_akun',
        'posisi_debit',
        'posisi_kredit',
    ];
}
