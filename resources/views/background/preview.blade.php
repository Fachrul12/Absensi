@extends('layouts.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Preview Background</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('background.index') }}">Kembali</a></li>
                    <li class="breadcrumb-item active">Preview Background</li>
                </ol>
            </div>
        </div>
    </div>
    <hr class="m-0">
</div>

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
                    <input type="range" class="form-control-range" id="qr_size" name="qr_size" min="50" max="500" value="{{ session('qr_size', 200) }}" oninput="updatePreview()" />
                    <span id="qr_size_value">{{ session('qr_size', 200) }} pixels</span>
                </div>
                <div class="form-group">
                    <label>QR Code Position:</label>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column align-items-center">
                            <button type="button" class="btn btn-secondary mb-2" onclick="moveUp()">▲</button>
                            <div>
                                <button type="button" class="btn btn-secondary mr-1" onclick="moveLeft()">◄</button>
                                <button type="button" class="btn btn-secondary ml-5" onclick="moveRight()">►</button>
                            </div>
                            <button type="button" class="btn btn-secondary mt-2" onclick="moveDown()">▼</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Center QR Code:</label>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="centerHorizontally()">Center Horizontally</button>
                            <button type="button" class="btn btn-primary" onclick="centerVertically()">Center Vertically</button>
                        </div>
                    </div>
                    
                    <input type="hidden" id="qr_position_x" name="qr_position_x" value="{{ session('qr_position_x', 175) }}" />
                    <input type="hidden" id="qr_position_y" name="qr_position_y" value="{{ session('qr_position_y', 450) }}" />
                </div>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<script>
    function moveUp() {
    const qrPositionY = document.getElementById('qr_position_y');
    qrPositionY.value = parseInt(qrPositionY.value) - 10;
    updatePreview();
}

function moveDown() {
    const qrPositionY = document.getElementById('qr_position_y');
    qrPositionY.value = parseInt(qrPositionY.value) + 10;
    updatePreview();
}

function moveLeft() {
    const qrPositionX = document.getElementById('qr_position_x');
    qrPositionX.value = parseInt(qrPositionX.value) - 10;
    updatePreview();
}

function moveRight() {
    const qrPositionX = document.getElementById('qr_position_x');
    qrPositionX.value = parseInt(qrPositionX.value) + 10;
    updatePreview();
}

function centerHorizontally() {
    const qrSize = parseInt(document.getElementById('qr_size').value);
    const backgroundImage = document.getElementById('background-preview');
    const bgWidth = backgroundImage.naturalWidth;
    
    const qrPositionX = Math.round((bgWidth / 2) - (qrSize / 2));
    document.getElementById('qr_position_x').value = qrPositionX;

    updatePreview();
}

function centerVertically() {
    const qrSize = parseInt(document.getElementById('qr_size').value);
    const backgroundImage = document.getElementById('background-preview');
    const bgHeight = backgroundImage.naturalHeight;

    const qrPositionY = Math.round((bgHeight / 2) - (qrSize / 2));
    document.getElementById('qr_position_y').value = qrPositionY;

    updatePreview();
}


function updatePreview() {
    const qrSize = document.getElementById('qr_size').value;
    const qrPositionX = document.getElementById('qr_position_x').value;
    const qrPositionY = document.getElementById('qr_position_y').value;

    document.getElementById('qr_size_value').textContent = qrSize + ' pixels';

    const qrPreview = document.getElementById('qr-preview');
    qrPreview.style.width = qrSize + 'px';
    qrPreview.style.left = qrPositionX + 'px';
    qrPreview.style.top = qrPositionY + 'px';

    const previewContainer = document.getElementById('preview-container');
    const containerWidth = previewContainer.offsetWidth;
    const qrWidth = qrPreview.offsetWidth;

    if (parseInt(qrPositionX) + qrWidth > containerWidth) {
        qrPreview.style.left = (containerWidth - qrWidth) + 'px';
    }
}


window.onload = function() {
    const backgroundImage = document.getElementById('background-preview');
    
    backgroundImage.onload = function() {
        const bgWidth = backgroundImage.naturalWidth;
        const bgHeight = backgroundImage.naturalHeight;

        const dimensionsText = `Background Size: ${bgWidth} x ${bgHeight} pixels`;
        document.getElementById('background-dimensions').innerText = dimensionsText;

        updatePreview();
    };
    
    if (backgroundImage.complete) {
        const bgWidth = backgroundImage.naturalWidth;
        const bgHeight = backgroundImage.naturalHeight;

        const dimensionsText = `Background Size: ${bgWidth} x ${bgHeight} pixels`;
        document.getElementById('background-dimensions').innerText = dimensionsText;

        updatePreview();
    }
};
</script>
@endsection
