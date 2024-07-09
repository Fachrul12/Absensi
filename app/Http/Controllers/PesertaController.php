<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Partai;
use App\Models\PendukungCalon;
use App\Models\Kategori;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesertas = Peserta::all();
        return view('pesertas.index', compact('pesertas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    $partais = Partai::all();
    $pendukung_calons = PendukungCalon::all();

    return view('peserta.create', compact('partais', 'pendukung_calons'));
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
        $peserta->partai_id = $request->input('nama_partai'); 
        $peserta->pendukung_calon_id = $request->input('pendukung_calon_id'); 
        $peserta->foto_peserta = $request->file('foto_peserta');
        // Get the uploaded file
    $file = $request->file('foto_peserta');

    // Do something with the file, e.g., store it in storage
    $file->storeAs('public/foto_peserta', $file->getClientOriginalName());
        // add more fields as needed
        $peserta->save();

        return redirect()->route('pesertas.index')->with('success', 'Peserta created successfully!');
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