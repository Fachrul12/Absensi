<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi Scan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container col-lg-4 py-5">
        <!-- Scanner -->
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
            <video id="preview"></video>

            <!-- Form -->
            <form action="{{ route('absensi.store') }}" method="POST" id="form">
                @csrf
                <input type="hidden" name="peserta_id" id="peserta_id">
                <input type="hidden" name="event_id" id="event_id">
            </form>
        </div>
        <!-- Scanner -->

        <div class="table-responsive mt-5">
            <table class="table table-bordered table-hover">
                <tr>                    
                    <th>Nama</th>
                    <th>Tanggal</th>
                </tr>
                @foreach ($pesertaHadir as $item)
                    <tr>
                        {{-- <td><img src="{{ $item->peserta->nama_peserta }}" alt="Foto" width="50"></td> --}}
                        <td>{{ $item->peserta->nama_peserta }}</td>
                        <td>{{ $item->tanggal_hadir }}</td>
                    </tr>
                @endforeach
            </table>
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
