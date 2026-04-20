@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-12" x-data="{ showClearModal: false }">

    {{-- Page Header --}}
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-cyan-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </span>
                    System Command Center
                </h1>
                <p class="text-slate-400 mt-2 ml-[52px] text-sm">Pusat kendali operasional tingkat tinggi SimOrgDes.</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 bg-slate-800/60 border border-slate-700/50 px-4 py-2 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_6px_rgba(52,211,153,0.6)]"></span>
                    <span class="text-xs font-semibold text-emerald-400">Server Online</span>
                </div>
                <div class="flex items-center gap-2 bg-slate-800/60 border border-slate-700/50 px-4 py-2 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_6px_rgba(34,211,238,0.6)]"></span>
                    <span class="text-xs font-semibold text-cyan-400">Database Stable</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center gap-3 text-emerald-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ============================================ --}}
        {{-- LEFT COLUMN (2/3 width) --}}
        {{-- ============================================ --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Section: System Controls --}}
            <div>
                <h2 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                    Kontrol Sistem
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- AI Chatbot Toggle --}}
                    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 hover:border-cyan-500/30 transition-all duration-300 group">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-11 h-11 rounded-xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400 group-hover:shadow-lg group-hover:shadow-cyan-500/10 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>

                            {{-- Toggle Switch for Chatbot --}}
                            <form action="{{ route('admin.settings.chatbot.update') }}" method="POST" id="chatbot-form">
                                @csrf
                                <label class="toggle-switch">
                                    <input type="checkbox" name="chatbot_active" {{ $chatbotActive ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span class="toggle-slider toggle-slider--cyan"></span>
                                </label>
                            </form>
                        </div>

                        <h3 class="text-white font-bold text-base mb-1">AI Chatbot Engine</h3>
                        <p class="text-slate-400 text-sm leading-relaxed mb-4">Gunakan AI untuk membalas pesan WhatsApp secara cerdas dan otomatis.</p>

                        <div class="flex items-center gap-2 pt-3 border-t border-slate-800">
                            <span class="w-2 h-2 rounded-full {{ $chatbotActive ? 'bg-cyan-400 shadow-[0_0_8px_rgba(34,211,238,0.7)] animate-pulse' : 'bg-slate-600' }}"></span>
                            <span class="text-xs font-bold uppercase tracking-wider {{ $chatbotActive ? 'text-cyan-400' : 'text-slate-500' }}">
                                {{ $chatbotActive ? 'Engine Online' : 'Engine Standby' }}
                            </span>
                        </div>
                    </div>

                    {{-- Maintenance Mode Toggle --}}
                    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 hover:border-amber-500/30 transition-all duration-300 group">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-11 h-11 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 group-hover:shadow-lg group-hover:shadow-amber-500/10 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>

                            {{-- Toggle Switch for Maintenance --}}
                            <form action="{{ route('admin.settings.maintenance.update') }}" method="POST" id="maintenance-form">
                                @csrf
                                <label class="toggle-switch">
                                    <input type="checkbox" name="maintenance_mode" {{ $maintenanceMode ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span class="toggle-slider toggle-slider--amber"></span>
                                </label>
                            </form>
                        </div>

                        <h3 class="text-white font-bold text-base mb-1">Maintenance Shield</h3>
                        <p class="text-slate-400 text-sm leading-relaxed mb-4">Proteksi akses sistem saat pemeliharaan atau perbaikan data.</p>

                        <div class="flex items-center gap-2 pt-3 border-t border-slate-800">
                            <span class="w-2 h-2 rounded-full {{ $maintenanceMode ? 'bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.7)] animate-pulse' : 'bg-slate-600' }}"></span>
                            <span class="text-xs font-bold uppercase tracking-wider {{ $maintenanceMode ? 'text-amber-400' : 'text-slate-500' }}">
                                {{ $maintenanceMode ? 'System Locked' : 'Live Access' }}
                            </span>
                        </div>
                    </div>

                    {{-- NEW: WhatsApp Receipt Toggle --}}
                    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 hover:border-emerald-500/30 transition-all duration-300 group">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-11 h-11 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover:shadow-lg group-hover:shadow-emerald-500/10 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>

                            {{-- Toggle Switch for Receipts --}}
                            <form action="{{ route('admin.settings.receipt.update') }}" method="POST" id="receipt-form">
                                @csrf
                                <label class="toggle-switch">
                                    <input type="checkbox" name="wa_receipt_enabled" {{ $receiptEnabled ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span class="toggle-slider toggle-slider--emerald"></span>
                                </label>
                            </form>
                        </div>

                        <h3 class="text-white font-bold text-base mb-1">WhatsApp Receipts</h3>
                        <p class="text-slate-400 text-sm leading-relaxed mb-4">Kirim struk konfirmasi pembayaran otomatis ke nomor anggota.</p>

                        <div class="flex items-center gap-2 pt-3 border-t border-slate-800">
                            <span class="w-2 h-2 rounded-full {{ $receiptEnabled ? 'bg-emerald-400 shadow-[0_0_8px_rgba(16,185,129,0.7)] animate-pulse' : 'bg-slate-600' }}"></span>
                            <span class="text-xs font-bold uppercase tracking-wider {{ $receiptEnabled ? 'text-emerald-400' : 'text-slate-500' }}">
                                {{ $receiptEnabled ? 'Notifications ON' : 'Notifications OFF' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Section: Bot Auto-Response --}}
            <div>
                <h2 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                    Pesan Standby Bot
                </h2>

                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-base">Bot Auto-Response</h3>
                            <p class="text-slate-400 text-xs mt-0.5">Pesan otomatis saat chatbot dalam keadaan standby</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.settings.standby.update') }}" method="POST">
                        @csrf
                        <textarea name="chatbot_standby_message" rows="3"
                            class="standby-textarea"
                            placeholder="Tulis pesan penyambut di sini...">{{ $standbyMessage }}</textarea>

                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/40 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Section: Activity Logs --}}
            <div>
                <h2 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    Log Aktivitas Bot
                    <div class="ml-auto flex items-center gap-2">
                        <button onclick="window.location.reload()" class="p-1.5 text-slate-500 hover:text-cyan-400 hover:bg-cyan-500/10 rounded-lg transition-all" title="Refresh Logs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                        </button>
                    </div>
                </h2>

                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-800/50 border-b border-slate-700/50">
                                    <th class="pl-8 pr-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-[0.1em] min-w-[160px]">Pengirim</th>
                                    <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-[0.1em] min-w-[200px]">Pesan & Interaksi</th>
                                    <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-[0.1em] text-center min-w-[100px]">Status</th>
                                    <th class="pl-4 pr-10 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-[0.1em] text-right min-w-[140px]">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/40">
                                @forelse($webhookLogs as $log)
                                <tr class="group hover:bg-slate-800/40 transition-all duration-200">
                                    <td class="pl-8 pr-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="hidden sm:flex w-8 h-8 rounded-lg bg-slate-800 border border-slate-700 items-center justify-center text-slate-500 group-hover:border-cyan-500/30 group-hover:text-cyan-400 transition-all flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            </div>
                                            <span class="text-sm font-semibold font-mono text-slate-300 group-hover:text-cyan-400 transition-colors whitespace-nowrap">{{ $log->sender }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="bg-slate-950/30 border border-slate-800/50 rounded-lg px-3 py-2 group-hover:border-slate-700/50 transition-all min-w-[180px]">
                                            <p class="text-sm text-slate-300 leading-relaxed break-words line-clamp-3" title="{{ $log->message }}">
                                                {{ $log->message }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex justify-center whitespace-nowrap">
                                            @if($log->status === 'success')
                                                <span class="status-badge status-badge--success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                                    Sukses
                                                </span>
                                            @elseif($log->status === 'skipped')
                                                <span class="status-badge status-badge--warning">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>
                                                    Dilewati
                                                </span>
                                            @else
                                                <span class="status-badge status-badge--danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                                    Gagal
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="pl-4 pr-10 py-4 text-right">
                                        <div class="flex flex-col items-end whitespace-nowrap">
                                            <span class="text-xs font-bold text-slate-400 group-hover:text-slate-200 transition-colors">{{ $log->created_at->diffForHumans() }}</span>
                                            <span class="text-[10px] text-slate-600 mt-0.5">{{ $log->created_at->format('H:i:s') }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="w-16 h-16 rounded-2xl bg-slate-800/50 flex items-center justify-center text-slate-700 border border-slate-700/50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                            </div>
                                            <div class="max-w-xs">
                                                <p class="text-slate-400 font-bold">Tidak Ada Aktivitas</p>
                                                <p class="text-slate-600 text-xs mt-1">Bot belum menerima atau memproses pesan apapun hari ini.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        {{-- ============================================ --}}
        {{-- RIGHT COLUMN (1/3 width) --}}
        {{-- ============================================ --}}
        <div class="space-y-6">

            {{-- System Overview Card --}}
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl overflow-hidden">

                {{-- Bot Usage Header --}}
                <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-5">
                    <p class="text-xs font-bold uppercase tracking-widest text-white/60 mb-2">Interaksi Bot Hari Ini</p>
                    <div class="flex items-end gap-2">
                        <span class="text-3xl font-extrabold text-white leading-none">{{ \App\Models\WebhookLog::whereDate('created_at', now())->count() }}</span>
                        <span class="text-sm font-semibold text-white/70 mb-0.5">pesan</span>
                    </div>
                </div>

                {{-- Status Items --}}
                <div class="p-5 space-y-4">

                    {{-- WhatsApp Connection --}}
                    @if(session('wa_status'))
                    <div class="p-3 rounded-xl text-xs {{ session('wa_status')['ok'] ? 'bg-emerald-500/10 border border-emerald-500/20 text-emerald-400' : 'bg-rose-500/10 border border-rose-500/20 text-rose-400' }}">
                        <p class="font-medium leading-relaxed">{{ session('wa_status')['message'] }}</p>
                    </div>
                    @endif

                    <a href="{{ route('admin.settings.wa.check') }}" class="flex items-center justify-between p-3 bg-slate-800/60 hover:bg-slate-800 rounded-xl transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.435 5.183l-1.42 5.186 5.312-1.393A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.25c-1.748 0-3.391-.491-4.793-1.347l-.343-.204-3.15.826.839-3.072-.224-.356A8.21 8.21 0 013.75 12c0-4.55 3.7-8.25 8.25-8.25s8.25 3.7 8.25 8.25-3.7 8.25-8.25 8.25z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">WhatsApp Gateway</p>
                                <p class="text-xs text-slate-500">Cek status koneksi API</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>

                    {{-- Divider --}}
                    <div class="border-t border-slate-800"></div>

                    {{-- Quick Status List --}}
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Chatbot AI</span>
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $chatbotActive ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : 'bg-slate-800 text-slate-500 border border-slate-700' }}">
                                {{ $chatbotActive ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Maintenance</span>
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $maintenanceMode ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'bg-slate-800 text-slate-500 border border-slate-700' }}">
                                {{ $maintenanceMode ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Laravel</span>
                            <span class="text-xs text-slate-500">v{{ app()->version() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">PHP</span>
                            <span class="text-xs text-slate-500">v{{ phpversion() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Clear Logs Confirmation Modal --}}
    <div x-show="showClearModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display: none;">
        <div x-show="showClearModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             class="bg-slate-900 border border-slate-700 rounded-2xl p-6 max-w-sm w-full mx-4 shadow-2xl">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
                </div>
                <h3 class="text-white font-bold">Hapus Semua Log?</h3>
            </div>
            <p class="text-slate-400 text-sm mb-6">Tindakan ini akan menghapus semua log aktivitas bot secara permanen dan tidak dapat dibatalkan.</p>
            <div class="flex items-center gap-3 justify-end">
                <button @click="showClearModal = false" class="px-4 py-2 text-sm font-medium text-slate-400 hover:text-white bg-slate-800 hover:bg-slate-700 rounded-xl transition">
                    Batal
                </button>
                <form action="{{ route('admin.settings.logs.clear') }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-500 rounded-xl transition shadow-lg shadow-rose-600/20">
                        Ya, Hapus Semua
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== Custom Toggle Switch ===== */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
        cursor: pointer;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }
    .toggle-slider {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #334155;
        border-radius: 9999px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .toggle-slider::before {
        content: "";
        position: absolute;
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: #94a3b8;
        border-radius: 50%;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    }
    .toggle-switch input:checked + .toggle-slider::before {
        transform: translateX(24px);
        background-color: #ffffff;
    }
    .toggle-switch input:checked + .toggle-slider--cyan {
        background-color: #0891b2;
        box-shadow: 0 0 16px rgba(6, 182, 212, 0.4);
    }
    .toggle-switch input:checked + .toggle-slider--amber {
        background-color: #d97706;
        box-shadow: 0 0 16px rgba(245, 158, 11, 0.4);
    }
    .toggle-switch input:checked + .toggle-slider--emerald {
        background-color: #059669;
        box-shadow: 0 0 16px rgba(16, 185, 129, 0.4);
    }

    /* ===== Standby Textarea ===== */
    .standby-textarea {
        width: 100%;
        background-color: #1e293b;
        border: 1px solid #475569;
        border-radius: 12px;
        color: #f1f5f9;
        font-size: 14px;
        line-height: 1.6;
        padding: 16px;
        resize: vertical;
        transition: all 0.3s ease;
        font-family: inherit;
    }
    .standby-textarea::placeholder {
        color: #64748b;
    }
    .standby-textarea:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        background-color: #1a2332;
    }

    /* ===== Status Badges ===== */
    .status-badge {
        display: inline-flex;
        items-center: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        padding: 4px 10px;
        border-radius: 9999px;
        transition: all 0.3s ease;
    }
    .status-badge--success {
        color: #10b981;
        background-color: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    .status-badge--warning {
        color: #f59e0b;
        background-color: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }
    .status-badge--danger {
        color: #ef4444;
        background-color: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* ===== Custom Scrollbar ===== */
    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }
</style>
@endsection
