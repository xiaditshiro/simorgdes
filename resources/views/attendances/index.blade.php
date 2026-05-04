@extends('layouts.app')

@section('content')

    <style>
        /* Custom UI for html5-qrcode scanner to match our premium dark mode */
        #reader {
            border: none !important;
            background: transparent !important;
        }
        #reader__dashboard_section_csr span, 
        #reader__dashboard_section_csr div {
            color: #cbd5e1 !important; /* text-slate-300 */
            font-size: 14px !important;
            margin-bottom: 8px !important;
            font-weight: 500 !important;
        }
        #reader select {
            width: 100% !important;
            background-color: #111827 !important;
            color: white !important;
            border: 1px solid #334155 !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            font-size: 14px !important;
            outline: none !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            margin-bottom: 15px !important;
        }
        #reader select:focus {
            border-color: #06b6d4 !important;
            box-shadow: 0 0 0 2px rgba(6, 182, 212, 0.2) !important;
        }
        #reader button {
            background: linear-gradient(to right, #06b6d4, #2563eb) !important;
            color: white !important;
            border: none !important;
            padding: 12px 24px !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
            margin-top: 5px !important;
            width: 100% !important;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.2) !important;
        }
        #reader button:hover {
            opacity: 0.9 !important;
            transform: translateY(-1px) !important;
        }
        #reader a {
            color: #38bdf8 !important; /* text-sky-400 */
            text-decoration: none !important;
            font-size: 13px !important;
            transition: color 0.2s !important;
            display: inline-block !important;
            margin-top: 10px !important;
        }
        #reader a:hover {
            color: #7dd3fc !important; /* text-sky-300 */
            text-decoration: underline !important;
        }
        #reader__scan_region {
            border-radius: 16px !important;
            overflow: hidden !important;
            margin-top: 20px !important;
        }
        #reader__dashboard_section_swaplink {
            text-align: center !important;
        }
    </style>

    <div class="space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">Absensi Kegiatan</h2>
                <p class="text-slate-400 mt-1">Kelola absensi anggota untuk kegiatan organisasi.</p>
            </div>

            <a href="{{ route('activities.index') }}"
                class="inline-flex items-center justify-center rounded-xl bg-slate-700 hover:bg-slate-600 px-5 py-3 text-sm font-medium text-white transition">
                ← Kembali ke Kegiatan
            </a>
        </div>

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6">
            <h3 class="text-xl font-semibold text-white mb-4">Informasi Kegiatan</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Kegiatan</p>
                    <p class="text-white font-semibold">{{ $activity->title }}</p>
                </div>

                <div class="rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Organisasi</p>
                    <p class="text-white font-semibold">{{ $activity->organization?->name }}</p>
                </div>

                <div class="rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Tanggal</p>
                    <p class="text-white font-semibold">{{ $activity->activity_date?->format('d-m-Y') }}</p>
                </div>

                <div class="rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Lokasi</p>
                    <p class="text-white font-semibold">{{ $activity->location ?: '-' }}</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-emerald-400 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <div id="scan-popup-overlay" style="z-index: 9999;"
            class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center transition-opacity duration-300">

            <div id="scan-popup" class="bg-gradient-to-b from-[#111827] to-[#0b1220] border border-slate-700/50 rounded-3xl shadow-2xl p-8 w-80 sm:w-96 text-center mx-4 transform scale-95 opacity-0 transition-all duration-300 ease-out">

                <div id="popup-icon-container" class="mx-auto w-20 h-20 rounded-full flex items-center justify-center mb-5 shadow-inner">
                    <div id="popup-icon" class="text-4xl drop-shadow-lg"></div>
                </div>

                <h3 id="popup-title" class="text-2xl font-bold text-white tracking-tight mb-2"></h3>
                <div id="popup-message" class="text-sm text-slate-400 font-medium leading-relaxed"></div>

            </div>
        </div>

        <input type="hidden" id="scan-url" value="{{ route('activities.attendances.scan', $activity->id) }}">
        <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">

        @if($members->count())
            <div class="flex flex-wrap gap-3">
                <button type="button" id="toggle-scanner"
                    class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                    Scan Anggota (Admin Scan QR Anggota)
                </button>

                <a href="{{ route('activities.qr', $activity->id) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-slate-800 border border-slate-700 hover:bg-slate-700 px-5 py-3 text-sm font-medium text-slate-300 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                    Buka QR Kegiatan (Untuk Scan Mandiri Anggota)
                </a>
            </div>

            <div id="scanner-wrapper" class="hidden rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Scanner QR Absensi</h3>

                <div id="reader" class="w-full max-w-md mx-auto overflow-hidden rounded-xl"></div>

                <div id="scan-result" class="mt-4 text-sm"></div>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg overflow-hidden">
            <form action="{{ route('activities.attendances.store', $activity->id) }}" method="POST">
                @csrf

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-[#111827] text-slate-300">
                            <tr>
                                <th class="px-4 py-4">No</th>
                                <th class="px-4 py-4">Nama Anggota</th>
                                <th class="px-4 py-4">Jabatan</th>
                                <th class="px-4 py-4">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#0b1220] text-slate-200">
                            @forelse($members as $index => $member)
                                @php
                                    $savedStatus = $attendanceMap[$member->id]->status ?? 'tidak_hadir';
                                @endphp
                                <tr class="border-t border-slate-700/50 hover:bg-slate-800/30 transition">
                                    <td class="px-4 py-4">{{ $index + 1 }}</td>

                                    <td class="px-4 py-4">
                                        {{ $member->full_name }}
                                        <input type="hidden" name="attendances[{{ $index }}][member_id]"
                                            value="{{ $member->id }}">
                                    </td>

                                    <td class="px-4 py-4">{{ ucfirst($member->position) }}</td>

                                    <td class="px-4 py-4">
                                        <select name="attendances[{{ $index }}][status]"
                                            class="rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                                            <option value="hadir" {{ $savedStatus == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                            <option value="tidak_hadir" {{ $savedStatus == 'tidak_hadir' ? 'selected' : '' }}>
                                                Tidak Hadir
                                            </option>
                                            <option value="izin" {{ $savedStatus == 'izin' ? 'selected' : '' }}>Izin</option>
                                        </select>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t border-slate-700/50">
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                                        Belum ada anggota pada organisasi ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($members->count())
                    <div class="p-6 border-t border-slate-700/50">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                            Simpan Absensi
                        </button>
                    </div>
                @endif
            </form>
        </div>

    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        let scanner = null;
        let scannerStarted = false;
        let lastScanned = null;

        const toggleButton = document.getElementById('toggle-scanner');
        const scannerWrapper = document.getElementById('scanner-wrapper');
        const resultBox = document.getElementById('scan-result');
        const scanUrl = document.getElementById('scan-url').value;
        const csrfToken = document.getElementById('csrf-token').value;
        const popup = document.getElementById('scan-popup');

        function showPopup(message, success = true) {
            const overlay = document.getElementById('scan-popup-overlay');
            const popup = document.getElementById('scan-popup');
            const popupIconContainer = document.getElementById('popup-icon-container');
            const popupIcon = document.getElementById('popup-icon');
            const popupTitle = document.getElementById('popup-title');
            const popupMessage = document.getElementById('popup-message');

            overlay.classList.remove('hidden');
            
            // Trigger reflow to restart animation
            void popup.offsetWidth;
            
            popup.classList.remove('scale-95', 'opacity-0');
            popup.classList.add('scale-100', 'opacity-100');

            if (success) {
                popupIconContainer.className = "mx-auto w-20 h-20 rounded-full flex items-center justify-center mb-5 shadow-inner bg-emerald-500/20 border border-emerald-500/30";
                popupIcon.innerHTML = "✨";
                popupTitle.innerHTML = "Berhasil";
                popupTitle.className = "text-2xl font-bold text-emerald-400 tracking-tight mb-2 drop-shadow-sm";
                popupMessage.innerHTML = message;
            } else {
                popupIconContainer.className = "mx-auto w-20 h-20 rounded-full flex items-center justify-center mb-5 shadow-inner bg-rose-500/20 border border-rose-500/30";
                popupIcon.innerHTML = "⚠️";
                popupTitle.innerHTML = "Peringatan";
                popupTitle.className = "text-2xl font-bold text-rose-400 tracking-tight mb-2 drop-shadow-sm";
                popupMessage.innerHTML = message;
            }

            // Hide after 2.5 seconds
            setTimeout(() => {
                popup.classList.remove('scale-100', 'opacity-100');
                popup.classList.add('scale-95', 'opacity-0');
                
                // Wait for CSS transition to finish before hiding overlay
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }, 2500);
        }

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
                .then(async res => {
                    const data = await res.json();
                    return { status: res.status, data };
                })
                .then(({ status, data }) => {
                    if (status >= 200 && status < 300 && data.success) {
                        resultBox.innerHTML = `
                                            <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-3 text-emerald-400">
                                                ${data.message}
                                            </div>
                                        `;
                        showPopup(data.message, true);
                    } else {
                        const msg = data.message ?? 'Gagal scan.';
                        resultBox.innerHTML = `
                                            <div class="rounded-xl border border-rose-500/30 bg-rose-500/10 p-3 text-rose-400">
                                                ${msg}
                                            </div>
                                        `;
                        showPopup(msg, false);
                    }

                    setTimeout(() => {
                        lastScanned = null;
                    }, 2000);
                })
                .catch(() => {
                    const msg = 'Terjadi kesalahan saat memproses scan.';
                    resultBox.innerHTML = `
                                        <div class="rounded-xl border border-rose-500/30 bg-rose-500/10 p-3 text-rose-400">
                                            ${msg}
                                        </div>
                                    `;
                    showPopup(msg, false);

                    setTimeout(() => {
                        lastScanned = null;
                    }, 2000);
                });
        }

        function onScanFailure(error) {
            // normal
        }

        function startScanner() {
            if (scannerStarted) return;

            scanner = new Html5QrcodeScanner(
                "reader",
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    rememberLastUsedCamera: true
                },
                false
            );

            scanner.render(onScanSuccess, onScanFailure);
            scannerStarted = true;
        }

        function toggleScanner() {
            scannerWrapper.classList.toggle('hidden');

            if (!scannerWrapper.classList.contains('hidden')) {
                startScanner();
                toggleButton.textContent = 'Tutup Scanner';
            } else {
                toggleButton.textContent = 'Scan QR Absensi';
            }
        }

        if (toggleButton) {
            toggleButton.addEventListener('click', toggleScanner);
        }
    </script>

@endsection