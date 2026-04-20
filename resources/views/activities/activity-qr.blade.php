@extends('layouts.app')

@push('styles')
<style>
    @media print {
        @page {
            margin: 0; /* This helps remove browser headers and footers */
        }

        /* Hide everything except the main content */
        aside, nav, .flex.items-center.justify-between, .mt-12.pt-8.border-t, .absolute.-inset-1 {
            display: none !important;
        }

        /* Reset body and content area */
        body {
            background: white !important;
            color: black !important;
            margin: 0 !important;
            padding: 1cm !important; /* Reduced padding */
        }

        main {
            padding: 0 !important;
            margin: 0 !important;
            background: transparent !important;
        }

        .max-w-2xl {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
        }

        /* Style the QR card for print */
        .relative.bg-\[\#0b1220\]\/90 {
            background: white !important;
            border: none !important;
            box-shadow: none !important;
            color: black !important;
            padding: 0 !important;
            margin: 0 !important;
            page-break-inside: avoid; /* Prevent splitting across pages */
        }

        .text-white, .text-slate-400 {
            color: black !important;
        }

        .text-3xl {
            font-size: 24pt !important;
        }

        .p-6.bg-white {
            padding: 0 !important;
            box-shadow: none !important;
            ring: none !important;
            border: none !important;
        }

        #activity-qr {
            width: 400px !important;
            height: 400px !important;
            margin: 20px auto !important;
        }

        #activity-qr img {
            width: 100% !important;
            height: 100% !important;
        }

        /* Ensure texts are visible and black */
        h3, p, span {
            color: black !important;
        }
        
        /* Hide live indicators for print */
        .bg-emerald-500\/10, .bg-amber-500\/10 {
            background: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
            color: black !important;
        }
    }
</style>
@endpush

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-white tracking-tight">QR Absensi Kegiatan</h2>
            <a href="{{ route('activities.attendances.index', $activity->id) }}" 
               class="px-5 py-2.5 bg-slate-800 text-slate-300 rounded-xl hover:bg-slate-700 hover:text-white transition-all flex items-center gap-2 border border-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
        </div>

        <div class="relative group">
            <!-- Glow Effect -->
            <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-[2rem] blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
            
            <div class="relative bg-[#0b1220]/90 backdrop-blur-xl border border-slate-700/50 rounded-3xl p-8 md:p-12 shadow-2xl text-center">
                <div class="mb-10">
                    <h3 class="text-3xl font-extrabold text-white mb-3 tracking-tight">{{ $activity->title }}</h3>
                    <div class="flex flex-col items-center gap-3">
                        <p class="text-slate-400 font-medium flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            {{ $activity->activity_date->format('d F Y') }}
                        </p>
                        <p class="text-slate-400 font-medium flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            {{ $activity->location }}
                        </p>
                    </div>

                    @if($activity->latitude && $activity->longitude)
                        <div class="mt-6 inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-500/10 text-emerald-400 rounded-full text-xs font-bold border border-emerald-500/20">
                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                            Proteksi GPS Aktif (Radius 50m)
                        </div>
                    @else
                        <div class="mt-6 inline-flex items-center gap-2 px-4 py-1.5 bg-amber-500/10 text-amber-400 rounded-full text-xs font-bold border border-amber-500/20">
                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                            Pengecekan Lokasi Tidak Aktif
                        </div>
                    @endif
                </div>

                <div class="flex justify-center">
                    <div class="p-6 bg-white rounded-[2rem] shadow-[0_0_50px_rgba(6,182,212,0.15)] ring-8 ring-slate-800/50">
                        <div id="activity-qr" class="w-[280px] h-[280px] flex items-center justify-center overflow-hidden">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=280x280&data={{ urlencode($payload) }}" 
                                 alt="QR Code" 
                                 class="w-full h-full object-contain"
                                 onload="this.parentElement.classList.remove('animate-pulse')"
                                 onerror="this.src='https://chart.googleapis.com/chart?cht=qr&chs=280x280&chl={{ urlencode($payload) }}'">
                        </div>
                    </div>
                </div>

                <div class="mt-12 space-y-2">
                    <p class="text-white font-semibold text-lg">Siap Discan</p>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-xs mx-auto">
                        Anggota silakan buka menu <strong>Scan Absensi Mandiri</strong> pada HP masing-masing untuk melakukan check-in.
                    </p>
                </div>

                <div class="mt-12 pt-8 border-t border-slate-800/50 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <button onclick="window.print()" class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 bg-slate-800 text-slate-300 rounded-xl hover:bg-slate-700 transition-all font-bold text-sm border border-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2-2 2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Cetak QR Code
                    </button>
                    
                    <div class="w-full sm:w-auto flex items-center justify-center gap-3 px-6 py-3 bg-cyan-500/10 text-cyan-400 rounded-xl border border-cyan-500/20 font-bold text-sm">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-cyan-500"></span>
                        </span>
                        Sesi Absensi Live
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>

@endsection
