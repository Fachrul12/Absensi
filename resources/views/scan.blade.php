<!-- resources/views/scan.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Scan QR Code</title>
    <script>
        function handleQRCodeScan(data) {
            fetch('/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ qrData: data })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Data berhasil disimpan!');
                } else {
                    alert('Gagal menyimpan data: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</head>
<body>
    <h1>Scan QR Code</h1>
    <!-- Tambahkan elemen untuk memindai QR code atau gunakan library untuk memindai QR code -->
    <!-- Setelah scan, panggil fungsi handleQRCodeScan(data) dengan data dari QR code -->
</body>
</html>
