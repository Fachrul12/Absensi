<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\KehadiranExport;
use Maatwebsite\Excel\Facades\Excel;

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

    return redirect()->route('events.index')->with('success', 'Berhasil Menambahkan Acara');
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

public function export($id)
{
    // Temukan event berdasarkan ID
    $event = Event::with('pesertas')->findOrFail($id);

    // Ambil data event beserta peserta
    $eventData = [
        'event' => [
            'id' => $event->id,
            'nama_event' => $event->nama_event,
            'tanggal_acara' => $event->tanggal_acara,
            'kategori_id' => $event->kategori_id,
            'created_at' => $event->created_at,
            'updated_at' => $event->updated_at,
        ],
        'pesertas' => $event->pesertas->map(function ($peserta) {
            return [
                'id' => $peserta->id,
                'nama_peserta' => $peserta->nama_peserta,
                'foto_peserta' => $peserta->foto_peserta,
                'isi_kategori_peserta_id' => $peserta->isi_kategori_peserta_id,
                'qr_code' => $peserta->qr_code,
                'created_at' => $peserta->created_at,
                'updated_at' => $peserta->updated_at,
            ];
        }),
    ];

    // Konversi data menjadi JSON
    $jsonEventData = json_encode($eventData, JSON_PRETTY_PRINT);

    // Set nama file
    $fileName = 'data_' . $event->nama_event . '_export.json';

    // Mengembalikan file JSON untuk didownload
    return response()->streamDownload(function () use ($jsonEventData) {
        echo $jsonEventData;
    }, $fileName, [
        'Content-Type' => 'application/json',
    ]);
}

public function import(Request $request)
{
    // Validasi file yang diunggah
    $request->validate([
        'import_file' => 'required|file|mimes:json',
    ]);

    // Ambil file JSON yang diunggah
    $jsonFile = $request->file('import_file');
    $jsonData = file_get_contents($jsonFile->getRealPath());
    $eventData = json_decode($jsonData, true);

    // Mulai transaksi database
    DB::beginTransaction();

    try {
        // Buat atau update event berdasarkan data yang diimport
        $event = Event::updateOrCreate(
            ['id' => $eventData['event']['id']],
            $eventData['event']
        );

        // Hapus semua peserta yang ada di event ini, lalu masukkan peserta dari JSON
        $event->pesertas()->delete();

        foreach ($eventData['pesertas'] as $pesertaData) {
            $event->pesertas()->create($pesertaData);
        }

        // Commit transaksi
        DB::commit();

        return redirect()->route('absensi.index')->with('success', 'Data berhasil diimport.');
    } catch (\Exception $e) {
        // Rollback jika ada kesalahan
        DB::rollBack();
        return redirect()->route('absensi.index')->with('error', 'Terjadi kesalahan saat mengimport data.');
    }
}

public function exportKehadiran($eventId)
{
    // Ambil data event dan pastikan ada
    $event = Event::findOrFail($eventId);

    // Ekspor data kehadiran
    return Excel::download(new KehadiranExport($eventId), 'kehadiran-' . $event->nama_event . '.xlsx');
}

}
