<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PartaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Models\Peserta;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\KategoriPesertaController;
use App\Http\Controllers\IsiKategoriPesertaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/absensi', [AbsensiController::class, 'index'])->middleware('auth')->name('absensi.index');
Route::get('/absensi/{id}', [AbsensiController::class, 'show'])->name('absensi.show')->middleware('auth');
Route::get('/absensi/event/{id}', [AbsensiController::class, 'create'])->name('absensi.create')->middleware('auth');
Route::post('/absensi/store/{event}', [AbsensiController::class, 'store'])->name('absensi.store')->middleware('auth');


// Route Event Baru
Route::resource('events', EventController::class)->middleware('admin');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show')->middleware('admin');

// QR Code
Route::get('/generate-qr-code/{pesertaId}', [QRCodeController::class, 'generateQRCode'])->middleware('admin');
Route::get('/peserta/{pesertaId}/qr-code', function ($pesertaId) {
    $peserta = Peserta::findOrFail($pesertaId);
    return view('qr-code', ['peserta' => $peserta]);
})->middleware('auth');

Route::resource('pesertas', PesertaController::class)->middleware('admin');
Route::get('/pesertas/create/{eventId}', [PesertaController::class, 'create'])->name('pesertas.create')->middleware('admin');
Route::get('/events/{eventId}', [PesertaController::class, 'index'])->name('pesertas.index')->middleware('admin');

// Route Kategori
Route::resource('kategoris', KategoriController::class)->middleware('admin');

// Ro

Route::resource('kategoripesertas', KategoriPesertaController::class)->middleware('admin');
Route::get('/kategoripesertas/{id}', [KategoriPesertaController::class, 'show'])->name('kategoripesertas.show')->middleware('admin');

Route::resource('isikategoripesertas', IsiKategoriPesertaController::class)->middleware('admin');
Route::get('/isikategoripesertas/create/{kategoripesertaId}', [IsiKategoriPesertaController::class, 'create'])->name('isikategoripesertas.create')->middleware('admin');
Route::get('/kategoripesertas/{kategoripesertaId}', [IsiKategoriPesertaController::class, 'index'])->name('isikategoripesertas.index')->middleware('admin');
Route::post('/kategoripesertas/{kategoripeserta}/isikategoripesertas', [IsiKategoriPesertaController::class, 'store'])->name('kategoripesertas.isikategoripesertas.store')->middleware('admin');

// Route Pengguna
Route::resource('users', UserController::class)->middleware('admin');

Route::get('/get-isi-kategori/{kategoriId}', [PesertaController::class, 'getIsiKategori']);
