<?php

use App\Models\Absen;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;

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

Route::get('/event', function () {
    return view('pages/event');
});


//route event
Route::get('/tambah_event', function () {
    return view('event/tambah');
});

Route::get('/view_event', function () {
    return view('event/view');
});

Route::get('/tambah_peserta', function () {
    return view('peserta/tambah');
});

Route::get('/edit_peserta', function () {
    return view('peserta/edit');
});






Route::get('/partai', function () {
    return view('pages/partai');
});

Route::get('/scan', function () {
    return view('welcome', [
        'absen' => Absen::all()
    ]);
});

Route::post('/store', [AbsensiController::class, 'store']) ->name('store');

// routes/web.php
Route::get('/datapeserta', function () {
    return view('datapeserta');
});
