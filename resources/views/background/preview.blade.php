@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <!-- Preview Section on the Left -->
        <div class="col-md-6">
            <h3>Preview QR Code with Background</h3>
            <p id="background-dimensions">Background Size: -- x -- pixels</p> <!-- Menampilkan ukuran background -->
            <div id="preview-container" style="position:relative; overflow: auto;">
                <img id="background-preview" src="{{ asset('storage/backgrounds/' . $background->image) }}" alt="Background Image" style="display: block; width: auto; height: auto;">
                <img id="qr-preview" src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code" style="position:absolute; top:{{ $qrPositionY }}px; left:{{ $qrPositionX }}px; width:{{ $qrSize }}px;">
            </div>
        </div>

        <!-- Edit Form on the Right -->
        <div class="col-md-6">
            <h3>Edit QR Code Placement</h3>
            <form id="edit-form" method="POST" action="{{ route('save.preview', ['backgroundId' => $background->id]) }}">
                @csrf
                <input type="hidden" name="backgroundId" value="{{ $background->id }}">
                <div class="form-group">
                    <label for="qr_size">QR Code Size (in pixels):</label>
                    <input type="number" class="form-control" id="qr_size" name="qr_size" value="{{ session('qr_size', 200) }}" />
                </div>
                <div class="form-group">
                    <label for="qr_position_x">QR Code X Position (in pixels):</label>
                    <input type="number" class="form-control" id="qr_position_x" name="qr_position_x" value="{{ session('qr_position_x', 175) }}" />
                </div>
                <div class="form-group">
                    <label for="qr_position_y">QR Code Y Position (in pixels):</label>
                    <input type="number" class="form-control" id="qr_position_y" name="qr_position_y" value="{{ session('qr_position_y', 450) }}" />
                </div>
                <button type="button" class="btn btn-primary" onclick="updatePreview()">Update Preview</button>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<script>
function updatePreview() {
    // Get values from form inputs
    const qrSize = document.getElementById('qr_size').value;
    const qrPositionX = document.getElementById('qr_position_x').value;
    const qrPositionY = document.getElementById('qr_position_y').value;

    // Update QR code preview
    const qrPreview = document.getElementById('qr-preview');
    qrPreview.style.width = qrSize + 'px';
    qrPreview.style.left = qrPositionX + 'px';
    qrPreview.style.top = qrPositionY + 'px';

    // Ensure the QR code stays within the preview container
    const previewContainer = document.getElementById('preview-container');
    const containerWidth = previewContainer.offsetWidth;
    const qrWidth = qrPreview.offsetWidth;

    if (parseInt(qrPositionX) + qrWidth > containerWidth) {
        qrPreview.style.left = (containerWidth - qrWidth) + 'px';
    }
}

window.onload = function() {
    const backgroundImage = document.getElementById('background-preview');
    
    // Setelah gambar di-load, dapatkan ukurannya
    backgroundImage.onload = function() {
        const bgWidth = backgroundImage.naturalWidth;
        const bgHeight = backgroundImage.naturalHeight;

        // Tampilkan ukuran background di elemen dengan id 'background-dimensions'
        const dimensionsText = `Background Size: ${bgWidth} x ${bgHeight} pixels`;
        document.getElementById('background-dimensions').innerText = dimensionsText;

        // Sesuaikan posisi QR Code agar berada di dalam background
        updatePreview();
    };
    
    // Jika gambar sudah di-cache, langsung dapatkan ukuran
    if (backgroundImage.complete) {
        const bgWidth = backgroundImage.naturalWidth;
        const bgHeight = backgroundImage.naturalHeight;

        const dimensionsText = `Background Size: ${bgWidth} x ${bgHeight} pixels`;
        document.getElementById('background-dimensions').innerText = dimensionsText;

        // Sesuaikan posisi QR Code agar berada di dalam background
        updatePreview();
    }
};
</script>
@endsection
