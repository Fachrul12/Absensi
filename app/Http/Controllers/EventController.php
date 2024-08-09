<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Peserta;
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
    $pesertas = Peserta::where('event_id', $id)->with('kehadiran')->get();
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
    $event = Event::findOrFail($id);

    $request->validate([
        'nama_event' => 'required|string',
        'kategori_id' => 'required|exists:kategoris,id',
        'tanggal_acara' => 'required|date',        
    ]);

    $event->nama_event = $request->input('nama_event');
    $event->kategori_id = $request->input('kategori_id');
    $event->tanggal_acara = $request->input('tanggal_acara');

    $event->save();

    // Update pendukung_calon records    

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
    
    // Akhirnya, hapus event itu sendiri
    $event->delete();

    return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
}



}
