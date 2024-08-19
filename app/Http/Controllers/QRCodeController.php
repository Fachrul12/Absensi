<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\PesertaHadir;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Background;

class QRCodeController extends Controller
{
    public function generateQRCode($pesertaId, Request $request)
    {
        $peserta = Peserta::findOrFail($pesertaId);
        $event = $peserta->event;

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

        // Get QR code settings from request
        $qrSize = $request->input('qr_size', 200);
        $qrCode = QrCode::format('png')->size($qrSize)->generate($dataString);

        // Get background path
        $backgroundPath = Storage::path('public/backgrounds/' . $event->background->image);

        if (!file_exists($backgroundPath)) {
            abort(404, 'Background image not found at ' . $backgroundPath);
        }

        // Get font settings from request
        $fontName = $request->input('font_name', 'Arial');
        $fontSize = $request->input('font_size', 16);
        $fontColor = $request->input('font_color', '#000000');

        // Create QR code with background and text
        $qrWithBackground = $this->addQRCodeToBackground(
            $qrCode, 
            $backgroundPath, 
            $peserta->nama_peserta, 
            $peserta->isiKategoriPeserta->kategoriPeserta->nama_kategori_peserta,
            $fontName,
            $fontSize,
            $fontColor
        );

        $fileName = 'qrcode_' . $peserta->nama_peserta . '.png';
        Storage::put('public/qrcodes/' . $fileName, $qrWithBackground);

        return response()->download(storage_path('app/public/qrcodes/' . $fileName))->deleteFileAfterSend(true);
    }

    public function store(Request $request)
    {
        $qrData = $request->input('qrData');

        // Parse JSON
        $data = json_decode($qrData, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            // Ensure parsing is successful
            $pesertaId = $data['id'];
            $eventId = $data['event_id'];

            // Create entry in peserta_hadirs table
            PesertaHadir::create([
                'peserta_id' => $pesertaId,
                'event_id' => $eventId,
                'tanggal' => now(),
            ]);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Invalid QR code data'], 400);
        }
    }

    public function addQRCodeToBackground($qrCode, $backgroundPath)
{
    // Ambil nilai dari session (contoh)
    $qrSize = session('qr_size', 300); // Default ke 300 jika tidak ada di session
    $qrPositionX = session('qr_position_x', 220);
    $qrPositionY = session('qr_position_y', 500);

    // Load the background image
    $background = new \Imagick($backgroundPath);

    // Load the QR code image from the string
    $qrImage = new \Imagick();
    $qrImage->readImageBlob($qrCode);

    // Resize QR code
    $qrImage->resizeImage($qrSize, $qrSize, \Imagick::FILTER_LANCZOS, 1);

    // Composite QR code onto background
    $background->compositeImage($qrImage, \Imagick::COMPOSITE_DEFAULT, $qrPositionX, $qrPositionY);

    // Save to temporary file
    $tempPath = storage_path('app/public/qrcodes/temp_' . uniqid() . '.png');
    $background->writeImage($tempPath);

    return file_get_contents($tempPath);
}


    public function downloadWithBackground($pesertaId, Request $request)
    {
        $peserta = Peserta::findOrFail($pesertaId);
        $event = $peserta->event;

        // Get QR code settings
        $qrSize = $request->input('qr_size', 200);
        $qrPositionX = $request->input('qr_position_x', 100);
        $qrPositionY = $request->input('qr_position_y', 100);

        $data = [
            'id' => $peserta->id,
            'event_id' => $peserta->event_id,
            'nama' => $peserta->nama_peserta,
            'foto' => $peserta->foto_peserta
        ];

        $dataString = json_encode($data);

        // Generate QR code
        $qrCode = QrCode::format('png')->size($qrSize)->generate($dataString);

        // Get background path
        $backgroundPath = Storage::path('public/backgrounds/' . $event->background->image);

        if (!file_exists($backgroundPath)) {
            abort(404, 'Background image not found at ' . $backgroundPath);
        }

        // Create QR code with background
        $qrWithBackground = $this->addQRCodeToBackground(
            $qrCode, 
            $backgroundPath, 
            $peserta->nama_peserta, 
            $peserta->isiKategoriPeserta->kategoriPeserta->nama_kategori_peserta,
            'Arial',
            16,
            '#000000'
        );

        $fileName = 'qrcode_' . $peserta->nama_peserta . '.png';
        Storage::put('public/qrcodes/' . $fileName, $qrWithBackground);

        return response()->download(storage_path('app/public/qrcodes/' . $fileName))->deleteFileAfterSend(true);
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

    public function preview($backgroundId)
    {
        $background = Background::findOrFail($backgroundId);
        
        // Generate QR Code (Customize data as needed)
        $qrCodeData = 'Example QR Code Data';
        $qrCode = QrCode::format('png')->size(200)->generate($qrCodeData);

        // Encode QR code as base64 to embed in HTML
        $qrCodeBase64 = base64_encode($qrCode);

        // Default values for QR code position and size
        $qrSize = $background->qr_size ?? 100;
        $qrPositionX = $background->qr_position_x ?? 50;
        $qrPositionY = $background->qr_position_y ?? 50;

        return view('background.preview', compact('background', 'qrCodeBase64', 'qrSize', 'qrPositionX', 'qrPositionY'));
    }

    public function updatePreview(Request $request, $backgroundId)
{
    $validated = $request->validate([
        'qr_size' => 'required|integer|min:100|max:1000',
        'qr_position_x' => 'required|integer|min:0',
        'qr_position_y' => 'required|integer|min:0',
    ]);

    $background = Background::findOrFail($backgroundId);
    $background->update([
        'qr_size' => $validated['qr_size'],
        'qr_position_x' => $validated['qr_position_x'],
        'qr_position_y' => $validated['qr_position_y'],
    ]);

    // Generate QR Code
    $qrCodeData = 'Example QR Code Data'; // Customize as needed
    $qrCode = QrCode::format('png')->size($validated['qr_size'])->generate($qrCodeData);

    // Encode QR code as base64 to embed in HTML
    $qrCodeBase64 = base64_encode($qrCode);

    return view('background.preview', compact('background', 'qrCodeBase64', 'validated.qr_size', 'validated.qr_position_x', 'validated.qr_position_y'));
}

public function showPreview($backgroundId)
{
    // Fetch the background based on the ID
    $background = Background::findOrFail($backgroundId);

    // Get QR code settings from session or use defaults
    $qrSize = session('qr_size', 300);
    $qrPositionX = session('qr_position_x', 220);
    $qrPositionY = session('qr_position_y', 500);

    // Generate QR Code (Customize data as needed)
    $qrCodeData = 'Example QR Code Data'; // Customize as needed
    $qrCode = QrCode::format('png')->size($qrSize)->generate($qrCodeData);

    // Encode QR code as base64 to embed in HTML
    $qrCodeBase64 = base64_encode($qrCode);

    return view('background.preview', compact('background', 'qrCodeBase64', 'qrSize', 'qrPositionX', 'qrPositionY'));
}


public function savePreview(Request $request)
{
    $validated = $request->validate([
        'qr_size' => 'required|integer|min:100|max:1000',
        'qr_position_x' => 'required|integer|min:0',
        'qr_position_y' => 'required|integer|min:0',
    ]);

    // Store the values in the session
    session()->put('qr_size', $validated['qr_size']);
    session()->put('qr_position_x', $validated['qr_position_x']);
    session()->put('qr_position_y', $validated['qr_position_y']);

    // Get the backgroundId from the request
    $backgroundId = $request->input('backgroundId');

    // Redirect to the preview page with the backgroundId parameter
    return redirect()->route('preview.page', ['backgroundId' => $backgroundId])->with('success', 'Settings saved.');
}

}
