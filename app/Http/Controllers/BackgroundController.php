<?php

namespace App\Http\Controllers;

use App\Models\Background;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;


class BackgroundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $backgrounds = Background::all();
        $events = Event::all();
        return view('pages.background', compact('backgrounds','events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('background.create');
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
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $background = new Background();
        $background->name = $request->name;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('backgrounds', 'public');
            $background->image = basename($imagePath);
        }

        $background->save();

        return redirect()->route('background.index')->with('success', 'Background berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Background  $background
     * @return \Illuminate\Http\Response
     */
    public function show(Background $background)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Background  $background
     * @return \Illuminate\Http\Response
     */
    public function edit(Background $background)
    {
        return view('background.edit', compact('background'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Background  $background
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Background $background)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $background->name = $request->name;

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($background->image) {
                Storage::disk('public')->delete('backgrounds/' . $background->image);
            }

            $imagePath = $request->file('image')->store('backgrounds', 'public');
            $background->image = basename($imagePath);
        }

        $background->save();

        return redirect()->route('background.index')->with('success', 'Background berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Background  $background
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $background = Background::findOrFail($id);
    
    // Mengupdate semua events yang menggunakan background ini
    Event::where('background_id', $id)->update(['background_id' => null]);
    
    // Hapus background setelah memastikan tidak ada event yang menggunakannya
    $background->delete();

    return redirect()->route('background.index')->with('success', 'Background berhasil dihapus.');
}



public function assignMultiple(Request $request, $backgroundId)
{
    $background = Background::findOrFail($backgroundId);
    
    // Ambil daftar event IDs yang dipilih
    $eventIds = $request->input('events', []);
    
    // Update event yang dipilih dengan background_id yang baru
    Event::whereIn('id', $eventIds)->update(['background_id' => $backgroundId]);

    // Set background_id menjadi null untuk event yang tidak dipilih lagi
    Event::where('background_id', $backgroundId)
        ->whereNotIn('id', $eventIds)
        ->update(['background_id' => null]);

    return redirect()->back()->with('success', 'Background assigned to selected events successfully.');
}



}
