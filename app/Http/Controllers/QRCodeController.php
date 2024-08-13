<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\PesertaHadir;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class QRCodeController extends Controller
{
    public function generateQRCode($pesertaId)
    {
        $peserta = Peserta::findOrFail($pesertaId);
        $event = $peserta->event;

        // Pastikan event memiliki background
        if (!$event->background) {
            return view('choose_background', [
                'event' => $event,
                'peserta' => $peserta
            ]);
        }
        

        $data = [
            'id' => $peserta->id,
            'event_id' => $peserta->event_id,
            'nama' => $peserta->nama_peserta,
            'foto' => $peserta->foto_peserta
        ];

        $dataString = json_encode($data);
        $qrCode = QrCode::format('png')->size(200)->generate($dataString);

        // Path gambar background
        $backgroundPath = Storage::path('public/backgrounds/' . $event->background->image);
        
        if (!file_exists($backgroundPath)) {
        abort(404, 'Background image not found at ' . $backgroundPath);
        }
        // Sisipkan QR code ke dalam gambar background
        $qrWithBackground = $this->addQRCodeToBackground($qrCode, $backgroundPath);

        // Simpan file dengan background
        $fileName = 'qrcode_' . $peserta->nama_peserta . '.png';
        Storage::put('public/qrcodes/' . $fileName, $qrWithBackground);

        return response()->download(storage_path('app/public/qrcodes/' . $fileName))->deleteFileAfterSend(true);
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

    public function addQRCodeToBackground($qrCode, $backgroundPath)
{
    
    $background = new \Imagick($backgroundPath);

    // Load the QR code image from the string
    $qrImage = new \Imagick();
    $qrImage->readImageBlob($qrCode);

    // Get dimensions
    $bgWidth = $background->getImageWidth();
    $bgHeight = $background->getImageHeight();
    $qrWidth = $qrImage->getImageWidth();
    $qrHeight = $qrImage->getImageHeight();

    // Calculate position (centered)
    $x = ($bgWidth - $qrWidth) / 2;
    $y = ($bgHeight - $qrHeight) / 2;

    // Composite the QR code onto the background
    $background->compositeImage($qrImage, \Imagick::COMPOSITE_DEFAULT, $x, $y);

    // Save to a temporary file
    $tempPath = storage_path('app/public/qrcodes/temp_' . uniqid() . '.png');
    $background->writeImage($tempPath);

    return file_get_contents($tempPath);
}



    public function downloadWithoutBackground($pesertaId)
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

    public function checkQRCodeStatus($pesertaId)
{
    $peserta = Peserta::findOrFail($pesertaId);
    $event = $peserta->event;

    if (!$event->backgrounds || count($event->backgrounds) === 0) {
        return view('choose_background', [
            'event' => $event,
            'peserta' => $peserta
        ]);
    }

    return redirect()->route('generate.qr.code', ['pesertaId' => $pesertaId]);
}
    
}
