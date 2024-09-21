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
    public function index(Request $request)
{
    $events = Event::query();

    // Cek jika ada permintaan untuk pengurutan berdasarkan status
    if ($request->has('sort') && $request->sort == 'status') {
        $events = $events->get()->sortBy(function ($event) {
            $tanggalAcara = \Carbon\Carbon::parse($event->tanggal_acara);
            if ($tanggalAcara < now()->startOfDay()) {
                return 3; // Selesai
            } elseif ($tanggalAcara->isToday()) {
                return 1; // Berlangsung
            } else {
                return 2; // Belum Selesai
            }
        });

        // Pengurutan berdasarkan arah (asc/desc)
        if ($request->get('direction') == 'desc') {
            $events = $events->reverse();
        }
    } else {
        $events = $events->get();
    }

    return view('pages.absensi', compact('events'));
}


public function store(Request $request, $event)
{
    // Check if manual data is provided
    if ($request->has('manual_data')) {
        // Decode the JSON data
        $data = json_decode($request->manual_data, true);
        $peserta_id = $data['id'] ?? null;
        $event_id = $data['event_id'] ?? null;

        // Validate peserta_id and event_id
        if (!$peserta_id || !$event_id) {
            return redirect()->back()->with('gagal', 'Invalid manual data provided.')->with('refocus', true);
        }
    } else {
        // Validate QR code data
        $validatedData = $request->validate([
            'peserta_id' => 'required|exists:pesertas,id',
            'event_id' => 'required|exists:events,id',
        ]);

        $peserta_id = $validatedData['peserta_id'];
        $event_id = $validatedData['event_id'];
    }

    // Ensure the event matches
    if ($event_id != $event) {
        return redirect()->back()->with('gagal', 'Peserta tidak ada didalam daftar')->with('refocus', true);
    }

    // Check for existing attendance
    $existingRecord = PesertaHadir::where('peserta_id', $peserta_id)
                                  ->where('event_id', $event_id)
                                  ->exists();

    if ($existingRecord) {
        return redirect()->back()->with('gagal', 'Peserta sudah absen')->with('refocus', true);
    }

    // Create new attendance record
    PesertaHadir::create([
        'peserta_id' => $peserta_id,
        'event_id' => $event_id,
        'tanggal_hadir' => now(),
    ]);

    // Fetch the participant to display
    $peserta = Peserta::find($peserta_id);

    // Set flash message
    return redirect()->back()->with([
        'success' => 'Peserta berhasil diabsen!',
        'peserta' => $peserta,
        'refocus' => true,
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