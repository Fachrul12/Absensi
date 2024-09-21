<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi Scanner</title>
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
            <!-- Form -->
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

                    <!-- Manual Input Form -->
                    <form action="{{ route('absensi.store', ['event' => $event->id]) }}" method="POST" id="form">
                        @csrf
                        <input type="hidden" name="peserta_id" id="peserta_id">
                        <input type="hidden" name="event_id" id="event_id">
                        <input type="text" name="manual_data" id="manual_data" placeholder="Masukkan data peserta" class="form-control mb-3">
                    </form>
                    
                </div>                
                <div class="card bg-white shadow rounded-3 p-3 border-0 mt-2">
                    <div class="mt-3">
                        <p class="text-muted">Jika input field tidak otomatis terfokus, silakan di klik lalu scan QR Code nya.</p>
                    </div>              
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

    <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        const manualInput = document.getElementById('manual_data');
        let typingTimer;
        const doneTypingInterval = 500; // Time in ms (1 second)

        // Function to focus on input field
        function focusInput() {
            manualInput.focus();
        }

        // Focus on the manual input field initially
        focusInput();

        // Listen for input events
        manualInput.addEventListener('input', function() {
            clearTimeout(typingTimer); // Clear the timer
            typingTimer = setTimeout(() => {
                const manualData = manualInput.value.trim();

                if (manualData) {
                    try {
                        const data = JSON.parse(manualData);
                        document.getElementById('peserta_id').value = data.id;
                        document.getElementById('event_id').value = data.event_id;
                        document.getElementById('form').submit();
                    } catch (e) {
                        alert("Format data tidak valid");
                        manualInput.value = ""; // Clear the input field
                        focusInput(); // Autofocus back to the input field
                    }
                }
            }, doneTypingInterval);
        });

        // Function to hide alert messages after a set time
        function hideAlertAfterDelay(alertElement) {
            setTimeout(() => {
                alertElement.style.display = 'none'; // Hide the alert
                focusInput(); // Autofocus after alert is hidden
            }, 3000); // Time in milliseconds (3 seconds)
        }

        // Hide success alerts
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            hideAlertAfterDelay(successAlert);
        }

        // Hide error alerts
        const errorAlert = document.querySelector('.alert-warning');
        if (errorAlert) {
            hideAlertAfterDelay(errorAlert);
        }

        // Autofocus after submission based on messages
        const successMessage = "{{ session('success') }}";
        const errorMessage = "{{ session('gagal') }}";
        const refocus = {{ session('refocus') ? 'true' : 'false' }};
        
        if (successMessage || errorMessage || refocus) {
            setTimeout(() => {
                focusInput(); // Autofocus again after a short delay
            }, 500);
        }

        // Also ensure focus after hiding alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            hideAlertAfterDelay(alert);
        });
    });
</script>

    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
