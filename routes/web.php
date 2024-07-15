<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PartaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

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
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate']);

// routes/web.php
Route::get('/register',[RegisterController::class, 'index'] );
Route::post('/register', [RegisterController::class, 'store']);


Route::get('/dashboard', function () {
    return view('pages/dashboard');
});



// Route Event Baru
Route::resource('events', EventController::class);
Route::get('/events/{id}', 'EventController@show')->name('events.show');



Route::resource('pesertas', PesertaController::class);
Route::get('/pesertas/create/{eventId}', 'PesertaController@create')->name('pesertas.create');
Route::get('/events/{eventId}', 'PesertaController@index')->name('pesertas.index');

Route::controller(PesertaController::class)->group(function () {
    Route::get('/pesertas/create/{eventId}', 'create')->name('pesertas.create');
});


Route::resource('kategoris', KategoriController::class);
Route::get('/kategoris/{eventId}', 'PesertaController@index')->name('pesertas.index');

Route::resource('partais', PartaiController::class);


Route::get('/partai', function () {
    return view('pages/partai');
});

Route::get('/kategori', function () {
    return view('pages/kategori');
});

