<?php

namespace App\Http\Controllers;

use App\Models\IsiKategoriPeserta;
use Illuminate\Http\Request;
use App\Models\KategoriPeserta;

class KategoriPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategoripesertas = KategoriPeserta::all();
        return view('pages.kategoripeserta', compact('kategoripesertas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategoripeserta.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kategoripeserta = new KategoriPeserta();
        $kategoripeserta->nama_kategori_peserta = $request->input('nama_kategori_peserta');        
        $kategoripeserta->save();

        // Redirect to the kategoripeserta list page
        return redirect()->route('kategoripesertas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kategoripesertas = KategoriPeserta::find($id);
        $isikategoripesertas = IsiKategoriPeserta::where('kategori_peserta_id', $id)->get();
        return view('kategoripeserta.show', compact('kategoripesertas', 'isikategoripesertas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $kategoripeserta = KategoriPeserta::find($id);
    
    return view('kategoripeserta.edit', compact('kategoripeserta'));
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
        $kategoripeserta = KategoriPeserta::findOrFail($id);

        $request->validate([
            'nama_kategori_peserta' => 'required|string',            
        ]);

        $kategoripeserta->update($request->all());

        return redirect()->route('kategoripesertas.index')->with('success', 'kategori peserta updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategoripeserta = KategoriPeserta::findOrFail($id);
        $kategoripeserta->delete();

        return redirect()->route('kategoripesertas.index')->with('success', 'kategori peserta deleted successfully!');
    }
}
