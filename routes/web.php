<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PenggajianController;

use App\Http\Controllers\PembelianBahanBakuController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

|
| Ini adalah file untuk mendefinisikan web routes. Middleware 'web' otomatis 
| aktif di sini (session, CSRF protection, dll). Cocok untuk form dan tampilan.
|

*/

// Halaman utama (bisa diganti nanti kalau perlu dashboard)
Route::get('/', function () {
    return view('welcome');
});


// Menampilkan form pembelian (GET)
Route::get('/pembelian', [PembelianBahanBakuController::class, 'create'])->name('pembelian.create');

// Menyimpan pembelian bahan baku (POST)
Route::post('/pembelian', [PembelianBahanBakuController::class, 'store'])->name('pembelian.store');

// Opsional: Jika kamu mau semua route pembelian (CRUD) sekaligus, gunakan resource
// Route::resource('pembelian', PembelianBahanBakuController::class);

Route::get('/hallo', function () {
    echo 'hai saya nazwa';
});


// Route Penggajian
Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
Route::get('/penggajian/create', [PenggajianController::class, 'create'])->name('penggajian.create');
Route::post('/penggajian/store', [PenggajianController::class, 'store'])->name('penggajian.store');
Route::get('/penggajian/{id}/edit', [PenggajianController::class, 'edit'])->name('penggajian.edit');
Route::put('/penggajian/{id}', [PenggajianController::class, 'update'])->name('penggajian.update');
Route::delete('/penggajian/{id}', [PenggajianController::class, 'destroy'])->name('penggajian.destroy');
Route::post('/presensi/masuk', [PresensiController::class, 'masuk'])->middleware('auth')->name('presensi.masuk');
Route::post('/presensi/keluar', [PresensiController::class, 'keluar'])->middleware('auth')->name('presensi.keluar');

 });

