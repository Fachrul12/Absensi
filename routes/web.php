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
Route::get('/pesertas/create/{eventId}', 'PesertaController@create')->name('pesertas.create');
Route::get('/events/{eventId}', 'PesertaController@index')->name('pesertas.index');

Route::controller(PesertaController::class)->group(function () {
    Route::get('/pesertas/create/{eventId}', 'create')->name('pesertas.create');
});


Route::resource('kategoris', KategoriController::class);

Route::resource('partais', PartaiController::class);


Route::get('/partai', function () {
    return view('pages/partai');
});

Route::get('/kategori', function () {
    return view('pages/kategori');
});





Route::get('/login', function () {
    return view('login');
});