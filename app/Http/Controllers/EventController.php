<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Peserta;
use App\Models\PendukungCalon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return view('pages.event', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('event.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $event = new Event();
    $event->nama_event = $request->input('nama_event');
    $event->kategori_id = $request->input('kategori_id');
    $event->tanggal_acara = $request->input('tanggal_acara');
    $event->status = 0; // Set a default value for status
    $event->save(); // Save the event instance first

    $pendukung_calon = $request->input('pendukung_calon');

    foreach ($pendukung_calon as $calon) {
        PendukungCalon::create([
            'event_id' => $event->id, // Use the saved event ID
            'nama_calon' => $calon,
            // Add other columns as needed
        ]);
    }

    return redirect()->route('events.index');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    $event = Event::find($id);
    $pesertas = Peserta::where('event_id', $id)->get();
    return view('event.view', compact('event', 'pesertas'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $event = Event::findOrFail($id);
    $kategoris = Kategori::all();
    $pendukung_calon = PendukungCalon::where('event_id', $id)->get();

    return view('event.edit', compact('event', 'kategoris', 'pendukung_calon'));
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);

    $request->validate([
        'nama_event' => 'required|string',
        'kategori_id' => 'required|exists:kategoris,id',
        'tanggal_acara' => 'required|date',
        'pendukung_calon' => 'nullable|array',
        'pendukung_calon.*' => 'nullable|string',
    ]);

    $event->nama_event = $request->input('nama_event');
    $event->kategori_id = $request->input('kategori_id');
    $event->tanggal_acara = $request->input('tanggal_acara');

    $event->save();

    // Update pendukung_calon records
    PendukungCalon::where('event_id', $id)->delete();
    foreach ($request->input('pendukung_calon') as $calon) {
        PendukungCalon::create([
            'event_id' => $id,
            'nama_calon' => $calon,
        ]);
    }

    return redirect()->route('events.index')->with('success', 'Event updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    // Temukan event berdasarkan ID
    $event = Event::findOrFail($id);

    // Temukan semua pendukung_calon terkait dengan event ini
    $pendukung_calons = PendukungCalon::where('event_id', $id)->get();

    // Iterasi setiap pendukung_calon
    foreach ($pendukung_calons as $pendukung_calon) {
        // Temukan semua peserta terkait dengan pendukung_calon ini
        $pesertas = Peserta::where('pendukung_calon_id', $pendukung_calon->id)->get();

        // Hapus setiap peserta terkait
        foreach ($pesertas as $peserta) {
            $peserta->delete();
        }

        // Hapus pendukung_calon
        $pendukung_calon->delete();
    }

    // Akhirnya, hapus event itu sendiri
    $event->delete();

    return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
}



}
