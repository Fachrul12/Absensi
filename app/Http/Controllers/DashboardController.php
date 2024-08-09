<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
{
    $now = now();

    $totalAcara = Event::count();
    $acaraAkanDatang = Event::where('tanggal_acara', '>', $now)->count();
    $acaraSedangBerlangsung = Event::whereDate('tanggal_acara', $now)->count();
    $acaraSudahSelesai = Event::where('tanggal_acara', '<', $now)->count();

    return view('pages.dashboard', compact('totalAcara', 'acaraAkanDatang', 'acaraSedangBerlangsung', 'acaraSudahSelesai'));
}
}
