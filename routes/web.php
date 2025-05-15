<?php

use Illuminate\Support\Facades\Route;
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
Route::get('/hallo', function () {
       echo 'hai saya nazwa';

return view('welcome');
});


// Menampilkan form pembelian (GET)
Route::get('/pembelian', [PembelianBahanBakuController::class, 'create'])->name('pembelian.create');

// Menyimpan pembelian bahan baku (POST)
Route::post('/pembelian', [PembelianBahanBakuController::class, 'store'])->name('pembelian.store');

// Opsional: Jika kamu mau semua route pembelian (CRUD) sekaligus, gunakan resource
// Route::resource('pembelian', PembelianBahanBakuController::class);

Route::get('/hallo', function () {
echo'hai saya dewan';

 });
