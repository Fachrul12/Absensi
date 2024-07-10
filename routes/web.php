<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PartaiController;

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
Route::get('/', function () {
    return view('pages/dashboard');
});

// Route Event Baru
Route::resource('events', EventController::class);
Route::get('/events/{id}', 'EventController@show')->name('events.show');



Route::resource('pesertas', PesertaController::class);
// Route::get('/events/{eventId}', 'EventController@show');
// Route::get('/pesertas/create?{eventId}', 'PesertaController@create')->name('pesertas.create');
Route::get('/pesertas/create?{eventId}', 'PesertaController@create')->name('pesertas.create');
Route::get('/pesertas/{eventId}', 'PesertaController@index')->name('pesertas.index');

Route::resource('kategoris', KategoriController::class);

Route::resource('partais', PartaiController::class);


Route::get('/partai', function () {
    return view('pages/partai');
});

Route::get('/kategori', function () {
    return view('pages/kategori');
});




Route::post('/store', [AbsensiController::class, 'store']) ->name('store');

// routes/web.php
Route::get('/datapeserta', function () {
    return view('datapeserta');
});
