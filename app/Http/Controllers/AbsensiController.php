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

    public function store(Request $request, $event)
{
    $validatedData = $request->validate([
        'peserta_id' => 'required|exists:pesertas,id',
        'event_id' => 'required|exists:events,id',
    ]);

    if ($validatedData['event_id'] != $event) {
        // Set flash message untuk kesalahan
        return redirect()->back()->with('gagal', 'Peserta tidak ada didalam daftar');
    }

    $existingRecord = PesertaHadir::where('peserta_id', $validatedData['peserta_id'])
                                  ->where('event_id', $validatedData['event_id'])
                                  ->exists();

    if ($existingRecord) {
        return redirect()->back()->with('gagal', 'Peserta sudah absen');
    }

    $validatedData['tanggal_hadir'] = now(); // Set the current timestamp

    PesertaHadir::create($validatedData);

    $peserta = Peserta::find($request->peserta_id);

    // Set flash message
    return redirect()->back()->with([
        'success' => 'Peserta berhasil diabsen!',
        'peserta' => $peserta,
    ]);
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