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



// Route Event Baru
Route::resource('events', EventController::class)->middleware('admin');
Route::get('/events/{id}', 'EventController@show')->name('events.show');



Route::resource('pesertas', PesertaController::class)->middleware('admin');
Route::get('/pesertas/create/{eventId}', 'PesertaController@create')->name('pesertas.create')->middleware('admin');
Route::get('/events/{eventId}', 'PesertaController@index')->name('pesertas.index');

Route::controller(PesertaController::class)->group(function () {
    Route::get('/pesertas/create/{eventId}', 'create')->name('pesertas.create'); 
});

//Route Kategori
Route::resource('kategoris', KategoriController::class)->middleware('admin');

//Route Partai
Route::resource('partais', PartaiController::class)->middleware('admin');

//Route Pengguna
Route::resource('users', UserController::class)->middleware('admin');

