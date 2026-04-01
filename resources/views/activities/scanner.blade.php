@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold mb-2">Scanner Absensi QR</h2>
        <p class="text-gray-600 mb-4">
            Kegiatan: {{ $activity->title }}
        </p>

        <div id="reader" class="max-w-md"></div>

        <div id="scan-result" class="mt-4 text-sm"></div>
    </div>

    <input type="hidden" id="scan-url" value="{{ route('activities.attendances.scan', $activity->id) }}">
    <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        const resultBox = document.getElementById('scan-result');
        const scanUrl = document.getElementById('scan-url').value;
        const csrfToken = document.getElementById('csrf-token').value;

        let lastScanned = null;

        function onScanSuccess(decodedText) {

            if (decodedText === lastScanned) return;
            lastScanned = decodedText;

            fetch(scanUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    qr_payload: decodedText
                })
            })
                .then(res => res.json())
                .then(data => {

                    if (data.success) {
                        resultBox.innerHTML =
                            `<div class="bg-green-100 text-green-700 p-3 rounded">
                    ${data.message}
                </div>`;
                    } else {
                        resultBox.innerHTML =
                            `<div class="bg-red-100 text-red-700 p-3 rounded">
                    ${data.message}
                </div>`;
                    }

                    setTimeout(() => {
                        lastScanned = null;
                    }, 2000);

                })
        }

        function onScanFailure(error) {
            // normal jika belum ada QR terbaca
        }

        const scanner = new Html5QrcodeScanner(
            "reader",
            {
                fps: 10,
                qrbox: 250
            }
        );

        scanner.render(onScanSuccess, onScanFailure);

    </script>
@endsection