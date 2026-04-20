@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-6 shadow-2xl">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                Scan Absensi Mandiri
            </h2>
            <p class="text-slate-400 text-sm mb-6">Arahkan kamera ke Kode QR Kegiatan yang disediakan Admin. Pastikan izin lokasi (GPS) sudah diaktifkan.</p>

            {{-- Location Status Card --}}
            <div id="location-status-card" class="mb-6 p-4 rounded-2xl border transition-all duration-300 flex items-center gap-4 bg-slate-800/40 border-slate-700/50">
                <div id="location-icon" class="w-10 h-10 rounded-full flex items-center justify-center bg-slate-700 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                </div>
                <div>
                    <h4 id="location-title" class="text-sm font-bold text-slate-200">Menunggu Lokasi...</h4>
                    <p id="location-desc" class="text-xs text-slate-500">Aplikasi sedang mencoba mendapatkan titik GPS Anda.</p>
                </div>
            </div>

            {{-- Scanner Area --}}
            <div id="scanner-container" class="relative rounded-2xl overflow-hidden border-2 border-slate-800 aspect-square max-w-sm mx-auto shadow-inner bg-black">
                <div id="reader" class="w-full h-full"></div>
                <div id="scanner-overlay" class="absolute inset-0 pointer-events-none border-[40px] border-black/40">
                    <div class="h-full w-full border-2 border-cyan-500/50 rounded-lg relative">
                        <div class="absolute top-0 left-0 w-4 h-4 border-t-4 border-l-4 border-cyan-400"></div>
                        <div class="absolute top-0 right-0 w-4 h-4 border-t-4 border-r-4 border-cyan-400"></div>
                        <div class="absolute bottom-0 left-0 w-4 h-4 border-b-4 border-l-4 border-cyan-400"></div>
                        <div class="absolute bottom-0 right-0 w-4 h-4 border-b-4 border-r-4 border-cyan-400"></div>
                        <div class="absolute top-1/2 left-0 w-full h-0.5 bg-cyan-500/30 animate-scan-line"></div>
                    </div>
                </div>
            </div>

            <div id="scan-result" class="mt-6"></div>
        </div>
    </div>

    {{-- Result Popup --}}
    <div id="scan-popup-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-md z-[100] flex items-center justify-center hidden transition-opacity duration-300">
        <div id="pop-content" class="bg-[#0b1220] border border-slate-700/50 p-10 rounded-[2.5rem] shadow-2xl scale-90 transition-transform duration-300 max-w-sm w-full text-center relative overflow-hidden group">
            <div id="pop-icon" class="mb-4"></div>
            <h3 id="pop-title"></h3>
            <p id="pop-desc" class="text-slate-400"></p>
            <button onclick="closePopup()" class="mt-8 px-8 py-3 bg-slate-800 text-slate-300 rounded-2xl hover:bg-slate-700 transition font-bold">Tutup</button>
        </div>
    </div>

    <input type="hidden" id="scan-url" value="{{ route('attendance.self-scan.store') }}">
    <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">

    <style>
        @keyframes scan-line {
            0% { top: 10%; opacity: 0; }
            50% { opacity: 1; }
            100% { top: 90%; opacity: 0; }
        }
        .animate-scan-line {
            animation: scan-line 2s infinite linear;
        }
        #reader__dashboard_section_csr button {
            background-color: #0891b2 !important;
            color: white !important;
            border-radius: 8px !important;
            padding: 8px 16px !important;
            border: none !important;
            font-size: 14px !important;
            margin: 10px 0 !important;
        }
    </style>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        const resultBox = document.getElementById('scan-result');
        const scanUrl = document.getElementById('scan-url').value;
        const csrfToken = document.getElementById('csrf-token').value;
        
        const locCard = document.getElementById('location-status-card');
        const locIcon = document.getElementById('location-icon');
        const locTitle = document.getElementById('location-title');
        const locDesc = document.getElementById('location-desc');

        let userCoords = null;
        let lastScanned = null;
        let isProcessing = false;

        // 1. Get Location First
        function initLocation() {
            if (!navigator.geolocation) {
                updateLocationUI('error', 'GPS Tidak Didukung', 'Browser Anda tidak mendukung fitur lokasi.');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    userCoords = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    updateLocationUI('success', 'Lokasi Terdeteksi', 'Koordinat GPS berhasil diamankan.');
                    startScanner();
                },
                (error) => {
                    let msg = 'Izin lokasi ditolak atau GPS tidak aktif.';
                    if(error.code == 1) msg = 'Mohon izinkan akses lokasi untuk melakukan absensi.';
                    updateLocationUI('error', 'Gagal Mendapatkan Lokasi', msg);
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }

        function updateLocationUI(status, title, desc) {
            locTitle.textContent = title;
            locDesc.textContent = desc;
            
            if (status === 'success') {
                locCard.classList.remove('bg-slate-800/40', 'border-slate-700/50');
                locCard.classList.add('bg-emerald-500/10', 'border-emerald-500/30');
                locIcon.className = 'w-10 h-10 rounded-full flex items-center justify-center bg-emerald-500 text-white shadow-[0_0_15px_rgba(16,185,129,0.3)]';
                locIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>`;
            } else if (status === 'error') {
                locCard.classList.remove('bg-slate-800/40', 'border-slate-700/50');
                locCard.classList.add('bg-rose-500/10', 'border-rose-500/30');
                locIcon.className = 'w-10 h-10 rounded-full flex items-center justify-center bg-rose-500 text-white shadow-[0_0_15px_rgba(244,63,94,0.3)]';
                locIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>`;
            }
        }

        function showPopup(success, message) {
            const overlay = document.getElementById('scan-popup-overlay');
            const content = document.getElementById('pop-content');
            const icon = document.getElementById('pop-icon');
            const title = document.getElementById('pop-title');
            const desc = document.getElementById('pop-desc');
            
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
            content.classList.add('scale-100');

            if (success) {
                icon.className = "w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center text-white mx-auto mb-4 shadow-lg shadow-emerald-500/20";
                icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 uppercase" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>`;
                title.textContent = "Berhasil!";
                title.className = "text-2xl font-bold text-white mb-2";
            } else {
                icon.className = "w-16 h-16 bg-rose-500 rounded-full flex items-center justify-center text-white mx-auto mb-4 shadow-lg shadow-rose-500/20";
                icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>`;
                title.textContent = "Gagal!";
                title.className = "text-2xl font-bold text-white mb-2";
            }
            desc.textContent = message;

            // Auto Close after 3s
            setTimeout(() => closePopup(), 3000);
        }

        function closePopup() {
            const overlay = document.getElementById('scan-popup-overlay');
            const content = document.getElementById('pop-content');
            overlay.classList.remove('opacity-100');
            content.classList.remove('scale-100');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
            
            isProcessing = false;
            lastScanned = null;
        }

        function onScanSuccess(decodedText) {
            if (isProcessing) return;
            if (decodedText === lastScanned) return;
            
            if (!userCoords) {
                alert('Tunggu hingga lokasi GPS terdeteksi.');
                return;
            }

            isProcessing = true;
            lastScanned = decodedText;
            
            resultBox.innerHTML = `<div class="p-4 bg-slate-800 rounded-2xl border border-slate-700 text-slate-300 animate-pulse text-center">Memproses Absensi...</div>`;

            fetch(scanUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    qr_payload: decodedText,
                    latitude: userCoords.lat,
                    longitude: userCoords.lng
                })
            })
            .then(res => res.json())
            .then(data => {
                resultBox.innerHTML = ''; // Clear processing status
                showPopup(data.success, data.message);
            })
            .catch(err => {
                isProcessing = false;
                lastScanned = null;
                console.error(err);
                resultBox.innerHTML = `<div class="p-4 bg-rose-500/10 text-rose-400 rounded-xl">Error: ${err.message}</div>`;
            });
        }

        function startScanner() {
            const scanner = new Html5QrcodeScanner(
                "reader",
                { fps: 10, qrbox: { width: 250, height: 250 } }
            );
            scanner.render(onScanSuccess);
        }

        // Auto-init on load
        window.addEventListener('load', initLocation);

    </script>
@endsection
