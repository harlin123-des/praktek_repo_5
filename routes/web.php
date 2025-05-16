<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembelianBahanBakuController;
use App\Http\Controllers\InvoiceController;

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

// Route testing hallo
Route::get('/hallo', function () {
    echo 'hai saya dewan';
    return view('welcome');
});

// Menampilkan form pembelian (GET)
Route::get('/pembelian', [PembelianBahanBakuController::class, 'create'])->name('pembelian.create');

// Menyimpan pembelian bahan baku (POST)
Route::post('/pembelian', [PembelianBahanBakuController::class, 'store'])->name('pembelian.store');

// Route untuk kirim email invoice
Route::get('/test-email', [InvoiceController::class, 'sendInvoice']);
