<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\PesertaHadir;

class QRCodeController extends Controller
{
    public function generateQRCode($pesertaId)
    {
        $peserta = Peserta::findOrFail($pesertaId);
        $data = [
            'id' => $peserta->id,
            'event_id' => $peserta->event_id
        ];

        // Konversi data menjadi format JSON atau string
        $dataString = json_encode($data);

        // Hasilkan QR code
        $qrCode = QrCode::format('svg')->size(200)->generate($dataString);

        // Kembalikan QR code sebagai gambar atau simpan di server
        return response($qrCode, 200)->header('Content-Type', 'image/svg+xml');
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
