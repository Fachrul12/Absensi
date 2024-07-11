<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Partai;
use App\Models\PendukungCalon;
use App\Models\Event;
use App\Models\Kategori;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($eventId)
{
    $event = Event::find($eventId);
    $pesertas = Peserta::where('event_id', $eventId)->get();
    return view('event.view', compact('event', 'pesertas'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
{
    $partais = Partai::all();
    $eventId = $request->route('eventId');
    $pendukung_calons = PendukungCalon::all();

    return view('peserta.create', compact('eventId', 'partais', 'pendukung_calons'));
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'nama_peserta' => 'required|string',
        // add more validation rules as needed
    ]);

    $peserta = new Peserta();
    $peserta->nama_peserta = $request->input('nama_peserta');
    $peserta->partai_id = $request->input('partai_id');
    $peserta->pendukung_calon_id = $request->input('pendukung_calon_id');

    $file = $request->file('foto_peserta');
    $file->storeAs('public/foto_peserta', $file->getClientOriginalName());
    $peserta->foto_peserta = $file->getClientOriginalName();
    
    $peserta->event_id = $request->input('eventId'); 
    $peserta->save();

    $eventId = $request->input('eventId');
    $event = Event::find($eventId);
    $pesertas = Peserta::where('event_id', $eventId)->get();


    return view('event.view', compact('event', 'pesertas'));
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $peserta = Peserta::find($id);
        return view('pesertas.show', compact('peserta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $peserta = Peserta::find($id);
        return view('pesertas.edit', compact('peserta'));
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
            'nama_peserta' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'alamat' => 'required|string',
            // add more validation rules as needed
        ]);

        $peserta = Peserta::find($id);
        $peserta->nama_peserta = $request->input('nama_peserta');
        $peserta->tanggal_lahir = $request->input('tanggal_lahir');
        $peserta->jenis_kelamin = $request->input('jenis_kelamin');
        $peserta->alamat = $request->input('alamat');
        // add more fields as needed
        $peserta->save();

        return redirect()->route('pesertas.index')->with('success', 'Peserta updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peserta = Peserta::find($id);
        $peserta->delete();
        return redirect()->route('pesertas.index')->with('success', 'Peserta deleted successfully!');
    }
}