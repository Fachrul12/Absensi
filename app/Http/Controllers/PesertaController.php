<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Event;
use App\Models\KategoriPeserta;
use App\Models\IsiKategoriPeserta;

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
    if (!$event) {
        return redirect()->back()->with('error', 'Event not found');
    }

    // Eager load nested relationships
    $pesertas = Peserta::where('event_id', $eventId)
                ->with('isiKategoriPeserta.kategoriPeserta') 
                ->get();

    return view('event.view', compact('event', 'pesertas'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
{    
    $eventId = $request->route('eventId');    
    $kategoriPesertas = KategoriPeserta::all();
    return view('peserta.create', compact('eventId','kategoriPesertas'));
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
    $peserta->isi_kategori_peserta_id = $request->input('isi_kategori_peserta_id');   

    $file = $request->file('foto_peserta');
    $file->storeAs('public/foto_peserta', $file->getClientOriginalName());
    $peserta->foto_peserta = $file->getClientOriginalName();
    
    $peserta->event_id = $request->input('eventId'); 
    $peserta->save();

    $eventId = $request->input('eventId');
    $event = Event::find($eventId);
    $pesertas = Peserta::where('event_id', $eventId)->get();


    return redirect()->route('pesertas.index', $eventId)->with('success', 'Peserta berhasil ditambah');
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
    $kategoriPesertas = KategoriPeserta::all();   
    $eventId = $peserta->event_id;    

    return view('peserta.edit', compact('peserta','eventId','kategoriPesertas'));
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
        // add more validation rules as needed
    ]);

    $peserta = Peserta::find($id);
    $peserta->nama_peserta = $request->input('nama_peserta');    
    $peserta->isi_kategori_peserta_id = $request->input('isi_kategori_peserta_id');   


    if ($request->hasFile('foto_peserta')) {
        $file = $request->file('foto_peserta');
        $file->storeAs('public/foto_peserta', $file->getClientOriginalName());
        $peserta->foto_peserta = $file->getClientOriginalName();
    }

    $peserta->save();

    $eventId = $peserta->event_id;
    $event = Event::find($eventId);
    $pesertas = Peserta::where('event_id', $eventId)->get();

    return redirect()->route('pesertas.index', $eventId)->with('success', 'Peserta edit successfully!');
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
    $eventId = $peserta->event_id;
    $peserta->delete();

    return redirect()->route('pesertas.index', $eventId)->with('success', 'Peserta deleted successfully!');
}

public function getIsiKategori($kategoriId)
{
    $isiKategoriPesertas = IsiKategoriPeserta::where('kategori_peserta_id', $kategoriId)->get(['id', 'nama_isi_kategori_peserta']);
    return response()->json($isiKategoriPesertas);
}

}