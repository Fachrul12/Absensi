<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PesertaController;

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




//Route::resource('pesertas', PesertaController::class);
Route::resource('pesertas', PesertaController::class);





Route::get('/partai', function () {
    return view('pages/partai');
});



Route::post('/store', [AbsensiController::class, 'store']) ->name('store');

// routes/web.php
Route::get('/datapeserta', function () {
    return view('datapeserta');
});
