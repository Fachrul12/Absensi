<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\Peserta;
use App\Models\PesertaHadir;
use App\Models\Event;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('pages.absensi', compact('events'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'peserta_id' => 'required|exists:pesertas,id',
        'event_id' => 'required|exists:events,id',
    ]);

    $validatedData['tanggal_hadir'] = now(); // Set the current timestamp

    PesertaHadir::create($validatedData);

    // Set flash message
    session()->flash('success', 'Peserta hadir berhasil dicatat.');

    // Redirect back to the same page
    return back();
}


    public function create($id)
    {
        $pesertaHadir = PesertaHadir::with('peserta', 'event')->get();        
        $pesertas = Peserta::all();
        $event = Event::find($id);

        return view('absensi.create', compact('pesertas', 'event','pesertaHadir'));
    }

    public function show($id)
    {
        $event = Event::find($id);
        $pesertas = Peserta::where('event_id', $id)->with('kehadiran')->get();
        return view('absensi.view', compact('event', 'pesertas'));
    }
    
}