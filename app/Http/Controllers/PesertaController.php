<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Event;
use App\Models\KategoriPeserta;
use App\Models\IsiKategoriPeserta;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PesertaImport;

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
            'isi_kategori_peserta_id' => 'required|integer',
            'foto_peserta' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $peserta = new Peserta();
        $peserta->nama_peserta = $request->input('nama_peserta');
        $peserta->isi_kategori_peserta_id = $request->input('isi_kategori_peserta_id');
        $peserta->event_id = $request->input('eventId');

        if ($request->hasFile('foto_peserta')) {
            $file = $request->file('foto_peserta');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/foto_peserta', $filename);
            $peserta->foto_peserta = $filename;
        }

        $peserta->save();

        return redirect()->route('pesertas.index', $peserta->event_id)->with('success', 'Peserta berhasil ditambah');
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
        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta not found');
        }
        return view('peserta.show', compact('peserta'));
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
    if (!$peserta) {
        return redirect()->back()->with('error', 'Peserta not found');
    }
    
    $kategoriPesertas = KategoriPeserta::all();
    $isiKategoriPesertas = IsiKategoriPeserta::where('kategori_peserta_id', $peserta->isiKategoriPeserta->kategori_peserta_id)->get();
    $eventId = $peserta->event_id;

    return view('peserta.edit', compact('peserta', 'kategoriPesertas', 'isiKategoriPesertas', 'eventId'));
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
            'isi_kategori_peserta_id' => 'required|integer',
            'foto_peserta' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $peserta = Peserta::find($id);
        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta not found');
        }

        $peserta->nama_peserta = $request->input('nama_peserta');
        $peserta->isi_kategori_peserta_id = $request->input('isi_kategori_peserta_id');

        if ($request->hasFile('foto_peserta')) {
            $file = $request->file('foto_peserta');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/foto_peserta', $filename);
            $peserta->foto_peserta = $filename;
        }

        $peserta->save();

        return redirect()->route('pesertas.index', $peserta->event_id)->with('success', 'Peserta berhasil diperbarui');
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
        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta not found');
        }
        
        $eventId = $peserta->event_id;
        $peserta->delete();

        return redirect()->route('pesertas.index', $eventId)->with('success', 'Peserta berhasil dihapus');
    }

    public function getIsiKategori($kategoriId)
{
    $isiKategoriPesertas = IsiKategoriPeserta::where('kategori_peserta_id', $kategoriId)->get(['id', 'nama_isi_kategori_peserta']);
    return response()->json($isiKategoriPesertas);
}


    public function import(Request $request, $event_id)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv'
    ]);

    // Import file dengan event_id
    Excel::import(new PesertaImport($event_id), $request->file('file'));

    return redirect()->route('pesertas.index', $event_id)->with('success', 'Peserta berhasil diimpor');
}


    public function showImportForm(Request $request)
    {
        $event_id = $request->route('event_id');
        return view('import', compact('event_id'));
    }
}
