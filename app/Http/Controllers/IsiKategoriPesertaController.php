<?php

namespace App\Http\Controllers;

use App\Models\IsiKategoriPeserta;
use App\Models\KategoriPeserta;
use Illuminate\Http\Request;

class IsiKategoriPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kategoripesertaId)
    {
        $kategoripeserta = KategoriPeserta::find($kategoripesertaId);
        $isikategoripesertas = IsiKategoriPeserta::where('kategori_peserta_id', $kategoripesertaId)->get();
        return view('kategoripeserta.show', compact('kategoripeserta', 'isikategoripesertas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {    
    $kategoripesertaId = $request->route('kategoripesertaId');    

    return view('isikategoripeserta.create', compact('kategoripesertaId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'nama_isi_kategori_peserta' => 'required|string',
        'kategoripesertaId' => 'required|integer',
    ]);

    // Create a new IsiKategoriPeserta entry
    IsiKategoriPeserta::create([
        'nama_isi_kategori_peserta' => $request->input('nama_isi_kategori_peserta'),
        'kategori_peserta_id' => $request->input('kategoripesertaId'),
    ]);

    // Retrieve the kategoripesertaId from the request
    $kategoripesertaId = $request->input('kategoripesertaId');

    // Redirect to the index route for the specific kategori peserta
    return redirect()->route('isikategoripesertas.index', ['kategoripesertaId' => $kategoripesertaId])->with('success', 'Berhasil Menambahkan Isi Kategori Peserta');
}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $isikategoripeserta = IsiKategoriPeserta::findOrFail($id);
        return view('isikategoripeserta.edit', compact('isikategoripeserta'));
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
        // Validate the incoming request data
        $request->validate([
            'nama_isi_kategori_peserta' => 'required|string',
        ]);

        $isikategoripeserta = IsiKategoriPeserta::findOrFail($id);
        $isikategoripeserta->update([
            'nama_isi_kategori_peserta' => $request->input('nama_isi_kategori_peserta'),
        ]);

        $kategoripesertaId = $isikategoripeserta->kategori_peserta_id;

        return redirect()->route('isikategoripesertas.index', ['kategoripesertaId' => $kategoripesertaId])
            ->with('success', 'Isi Kategori Peserta updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Find the IsiKategoriPeserta by its ID
            $isikategoripeserta = IsiKategoriPeserta::findOrFail($id);
    
            // Retrieve the kategori_peserta_id to redirect back later
            $kategoripesertaId = $isikategoripeserta->kategori_peserta_id;
    
            // Attempt to delete the IsiKategoriPeserta entry
            $isikategoripeserta->delete();
    
            // Redirect to the index route with a success message
            return redirect()->route('isikategoripesertas.index', ['kategoripesertaId' => $kategoripesertaId])
                ->with('success', 'Isi Kategori Peserta Berhasil Dihapus!');
        } catch (\Exception $e) {
            // Ensure $kategoripesertaId is available even in case of an error
            $kategoripesertaId = $isikategoripeserta->kategori_peserta_id ?? null;
    
            // Redirect to the index route with an error message
            return redirect()->route('isikategoripesertas.index', ['kategoripesertaId' => $kategoripesertaId])
                ->with('error', 'Gagal Menghapus Isi Kategori, Isi Kategori Digunakan pada Peserta');
        }
    }
}
