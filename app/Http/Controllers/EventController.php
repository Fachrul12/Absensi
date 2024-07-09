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
        return view('event.edit', compact('event', 'kategoris'));
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
        $request->validate([
            'nama_event' => 'required',
            'kategori_event' => 'required',
            'tanggal_acara' => 'required',
        ]);

        $event = Event::findOrFail($id);
        $event->nama_event = $request->nama_event;
        $event->kategori_event = $request->kategori_event;
        $event->tanggal_acara = $request->tanggal_acara;
        $event->save();

        return redirect('/event')->with('success', 'Event berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect('/event')->with('success', 'Event berhasil dihapus');
    }
}
