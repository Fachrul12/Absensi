<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partai;

class PartaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partais = Partai::all();
        return view('pages.partai', compact('partais'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('partai.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
  // Get the uploaded file
  $bendera_partai = $request->file('bendera_partai');

  // Store the file in the storage directory
  $bendera_partai->storeAs('public/partai', $bendera_partai->getClientOriginalName());

  // Create a new partai instance
  $partai = new Partai();
  $partai->nama_partai = $request->input('nama_partai');
  $partai->bendera_partai = $bendera_partai->getClientOriginalName();
  $partai->save();

  // Redirect to the partai list page
  return redirect()->route('partais.index');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $partai = Partai::findOrFail($id);
        return view('partai.show', compact('partai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partai = Partai::findOrFail($id);
        $partais = Partai::all();
        return view('partai.edit', compact('partai'));
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
        $partai = Partai::findOrFail($id);

        $request->validate([
            'nama_partai' => 'required|string',
            'bendera_partai' => 'required|string',
        ]);

        $partai->update($request->all());

        return redirect()->route('partais.index')->with('success', 'Partai updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partai = Partai::findOrFail($id);
        $partai->delete();

        return redirect()->route('partais.index')->with('success', 'Partai deleted successfully!');
    }
}