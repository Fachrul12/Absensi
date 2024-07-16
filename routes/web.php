<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PartaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;

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
Route::get('/logout', [LoginController::class, 'logout']);

// routes/web.php
Route::get('/register',[RegisterController::class, 'index'] );
Route::post('/register', [RegisterController::class, 'store']);


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');



// Route Event Baru
Route::resource('events', EventController::class)->middleware('auth');
Route::get('/events/{id}', 'EventController@show')->name('events.show');



Route::resource('pesertas', PesertaController::class)->middleware('auth');
Route::get('/pesertas/create/{eventId}', 'PesertaController@create')->name('pesertas.create');
Route::get('/events/{eventId}', 'PesertaController@index')->name('pesertas.index');

Route::controller(PesertaController::class)->group(function () {
    Route::get('/pesertas/create/{eventId}', 'create')->name('pesertas.create'); 
});


Route::resource('kategoris', KategoriController::class)->middleware('auth');
Route::get('/kategoris/{eventId}', 'PesertaController@index')->name('pesertas.index');

Route::resource('partais', PartaiController::class)->middleware('auth');

//Route Pengguna
Route::resource('users', UserController::class)->middleware('admin');




Route::post('/store', [AbsensiController::class, 'store']) ->name('store');

// routes/web.php
Route::get('/datapeserta', function () {
    return view('datapeserta');
});
