<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi Scan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .offset-lg-1 {
            margin-left: 8.333333%;
        }
        .float-right {
            float: right;
        }
    </style>
</head>
<body>
    <div class="container col-lg-10 offset-lg-1 py-5">
        <a href="{{ route('absensi.show', $event->id) }}" class="btn btn-secondary mb-3 float-left">Kembali</a>
        <div class="row">
            <!-- Scanner -->
            <div class="col-lg-6">
                <div class="card bg-white shadow rounded-3 p-3 border-0">
                    <!-- Pesan -->
                    @if (session()->has('gagal'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('gagal') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="scanner"></div>
                    <video id="preview" class="w-100"></video>

                    <!-- Form -->
                    <form action="{{ route('absensi.store', ['event' => $event->id]) }}" method="POST" id="form">
                        @csrf
                        <input type="hidden" name="peserta_id" id="peserta_id">
                        <input type="hidden" name="event_id" id="event_id">
                    </form>
                </div>
            </div>

            <!-- Tampilan Data Peserta -->
            <div class="col-lg-4">
                @if (session()->has('peserta'))
                    <div class="card bg-light shadow rounded-3 p-3 border-0">
                        <img src="{{ asset('storage/foto_peserta/' . session()->get('peserta')->foto_peserta) }}" alt="Foto Peserta" class="img-thumbnail mb-3">
                        <h4>{{ session()->get('peserta')->nama_peserta }}</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        scanner.addListener('scan', function (content) {
            console.log(content);
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });

        scanner.addListener('scan', function(c) {
            let qrData = JSON.parse(c);
            document.getElementById('peserta_id').value = qrData.id;
            document.getElementById('event_id').value = qrData.event_id;
            document.getElementById('form').submit();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
