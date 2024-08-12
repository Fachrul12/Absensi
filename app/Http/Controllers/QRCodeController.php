<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\PesertaHadir;
use Illuminate\Support\Facades\Storage;

class QRCodeController extends Controller
{
    public function generateQRCode($pesertaId)
    {
        $peserta = Peserta::findOrFail($pesertaId);
        $data = [
            'id' => $peserta->id,
            'event_id' => $peserta->event_id,
            'nama' => $peserta->nama_peserta,
            'foto' => $peserta->foto_peserta
        ];

        // Konversi data menjadi format JSON atau string
        $dataString = json_encode($data);

        // Hasilkan QR code dalam format PNG
        $qrCode = QrCode::format('png')->size(200)->generate($dataString);

        // Nama file untuk disimpan
        $fileName = 'qrcode_'.$peserta->nama_peserta.'.png';

        // Simpan file QR code di dalam storage
        Storage::put('public/qrcodes/'.$fileName, $qrCode);

        // Berikan response untuk mengunduh file gambar PNG
        return response()->download(storage_path('app/public/qrcodes/'.$fileName))->deleteFileAfterSend(true);
    }

    public function store(Request $request)
    {
        $qrData = $request->input('qrData'); // Asumsi data dikirim via POST dengan field 'qrData'

        // Parsing JSON
        $data = json_decode($qrData, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            // Pastikan parsing berhasil
            $pesertaId = $data['id'];
            $eventId = $data['event_id'];

            // Buat entri baru di tabel peserta_hadirs
            PesertaHadir::create([
                'peserta_id' => $pesertaId,
                'event_id' => $eventId,
                'tanggal' => now(), // atau sesuaikan dengan tanggal yang diinginkan
            ]);

            return response()->json(['success' => true]);
        } else {
            // Jika JSON tidak valid
            return response()->json(['error' => 'Invalid QR code data'], 400);
        }
    }
}
