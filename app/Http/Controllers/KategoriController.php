<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategoris = Kategori::all();
        return view('pages.kategori', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{        
    return view('kategori.create');
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
        'nama_kategori' => 'required|string',
    ]);

    $kategori = new Kategori();
    $kategori->nama_kategori = $request->input('nama_kategori');
    $kategori->save();

    return redirect()->route('kategoris.index')->with('success', 'Berhasil Menambahkan Kategori Acara');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    $kategori = Kategori::find($id);    
    return view('kategori.view', compact('kategori'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);        
        return view('kategori.edit', compact('kategori'));
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
            'nama_kategori' => 'required|string',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->nama_kategori = $request->input('nama_kategori');
        $kategori->save();

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diubah');
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
        // Find the Kategori by its ID
        $kategori = Kategori::findOrFail($id);

        // Delete the Kategori entry
        $kategori->delete();

        // Redirect with a success message
        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dihapus');
    } catch (\Exception $e) {
        // Redirect with an error message if something goes wrong
        return redirect()->route('kategoris.index')->with('error', 'Gagal menghapus kategori. Silakan coba lagi.');
    }
}

}

