@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">Detail Proposal</h2>
                <p class="text-slate-400 mt-1">Informasi lengkap terkait permohonan yang diajukan.</p>
            </div>

            <a href="{{ url()->previous() }}"
                class="inline-flex items-center justify-center rounded-xl bg-slate-700 hover:bg-slate-600 px-5 py-3 text-sm font-medium text-white transition whitespace-nowrap">
                ← Kembali
            </a>
        </div>

        {{-- Card Container --}}
        <div class="rounded-3xl border border-slate-700/60 bg-[#0b1220]/90 shadow-2xl p-6 sm:p-10 backdrop-blur-sm space-y-8">
            
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 pb-6 border-b border-slate-700/50">
                <div class="flex-1">
                    <h3 class="text-2xl sm:text-3xl font-black text-white leading-tight tracking-tight italic">{{ $proposal->title }}</h3>
                    <div class="flex flex-wrap items-center gap-4 mt-4">
                        <div class="flex items-center gap-2 text-xs text-slate-400 font-mono">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($proposal->proposal_date)->format('d F Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-slate-400 font-mono">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                             </svg>
                             <span>ID: #{{ str_pad($proposal->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>

                <div class="shrink-0">
                    @if($proposal->status == 'pending')
                        <span class="inline-flex items-center gap-2 rounded-full bg-yellow-500/10 px-4 py-2 text-xs font-black text-yellow-500 border border-yellow-500/30 uppercase tracking-widest italic">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
                            </span>
                            Menunggu Persetujuan
                        </span>
                    @elseif($proposal->status == 'approved')
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-4 py-2 text-xs font-black text-emerald-400 border border-emerald-500/30 uppercase tracking-widest italic">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Disetujui
                        </span>
                    @elseif($proposal->status == 'rejected')
                        <span class="inline-flex items-center gap-2 rounded-full bg-rose-500/10 px-4 py-2 text-xs font-black text-rose-400 border border-rose-500/30 uppercase tracking-widest italic">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            Ditolak
                        </span>
                    @endif
                </div>
            </div>

            {{-- Grid Data --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Organisasi Pengirim --}}
                <div class="bg-slate-800/20 rounded-2xl p-5 border border-slate-700/50 hover:bg-slate-800/40 transition">
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest font-black mb-2 italic">Organisasi Pengirim</p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 font-bold text-xs">
                             {{ substr($proposal->organization?->name ?? '?', 0, 1) }}
                        </div>
                        <p class="text-slate-200 font-bold">{{ $proposal->organization?->name ?? 'Tidak Diketahui' }}</p>
                    </div>
                </div>

                {{-- Dikirim Ke --}}
                <div class="bg-slate-800/20 rounded-2xl p-5 border border-slate-700/50 hover:bg-slate-800/40 transition">
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest font-black mb-2 italic">Tujuan Pengiriman</p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 font-bold text-xs">
                             {{ $proposal->target_type === 'desa' ? 'D' : substr($proposal->targetOrganization?->name ?? '?', 0, 1) }}
                        </div>
                        <p class="text-slate-200 font-bold">
                            @if($proposal->target_type === 'desa')
                                Kantor Desa
                            @else
                                {{ $proposal->targetOrganization?->name ?? '-' }}
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2 bg-slate-800/20 rounded-2xl p-6 border border-slate-700/50">
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest font-black mb-4 italic">Ringkasan Konteks</p>
                    <div class="text-slate-300 leading-relaxed text-sm">
                        {!! nl2br(e($proposal->description ?? 'Tidak ada ringkasan deskripsi yang diberikan.')) !!}
                    </div>
                </div>

                {{-- Dokumen --}}
                <div class="md:col-span-2 bg-gradient-to-r from-cyan-500/5 to-blue-500/5 rounded-2xl p-6 border border-cyan-500/20 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-cyan-500/20 rounded-xl text-cyan-400 border border-cyan-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-200 font-bold">Dokumen Lampiran</p>
                            <p class="text-xs text-slate-400">Klik tombol di samping untuk mengunduh berkas proposal (PDF).</p>
                        </div>
                    </div>
                    
                    @if($proposal->file_path)
                        <a href="{{ asset('storage/' . $proposal->file_path) }}" target="_blank"
                            class="inline-flex items-center justify-center rounded-xl bg-cyan-500 px-6 py-3 text-sm font-black text-black hover:bg-cyan-400 transition shadow-lg shadow-cyan-500/20 shrink-0">
                            Download Berkas
                        </a>
                    @else
                        <span class="text-sm text-slate-500 italic">Berkas tidak tersedia</span>
                    @endif
                </div>
            </div>

            {{-- AKSI --}}
            @php
                $user = auth()->user();
                $canApprove = false;
                
                if ($proposal->target_type === 'desa' && ($user->hasRole('admin_desa') || $user->hasRole('super_admin'))) {
                    $canApprove = true;
                } elseif ($proposal->target_type === 'organization' && $proposal->target_organization_id == $user->organization_id) {
                    $canApprove = true;
                } elseif ($user->hasRole('super_admin')) {
                    $canApprove = true;
                }

                if ($proposal->organization_id == $user->organization_id && !$user->hasRole('super_admin')) {
                    $canApprove = false;
                }
            @endphp

            @if($proposal->status == 'pending' && $canApprove)
                <div class="pt-8 border-t border-slate-700/50 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <form action="{{ route('proposals.approve', $proposal->id) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <button class="w-full px-10 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-green-600 text-white text-sm font-black uppercase tracking-widest shadow-xl shadow-emerald-500/30 hover:scale-105 active:scale-95 transition">
                            Terima Proposal
                        </button>
                    </form>

                    <form action="{{ route('proposals.reject', $proposal->id) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" onclick="return confirm('Yakin ingin menolak proposal ini?')"
                            class="w-full px-10 py-4 rounded-2xl bg-slate-800 border border-slate-700 text-rose-500 text-sm font-black uppercase tracking-widest hover:bg-rose-500/10 hover:border-rose-500/30 transition">
                            Tolak Proposal
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Diskusi Box --}}
        <div class="rounded-3xl border border-slate-700/60 bg-[#0b1220]/80 shadow-2xl overflow-hidden p-6 sm:p-10 mb-10">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/20 flex items-center justify-center border border-cyan-500/30 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white tracking-tight">Diskusi Proposal</h3>
                        <p class="text-xs text-slate-400">Gunakan fitur chat ini untuk koordinasi proposal.</p>
                    </div>
                </div>
                <span class="bg-cyan-500/10 text-cyan-400 text-xs font-semibold px-3 py-1 rounded-full border border-cyan-500/20 uppercase tracking-widest">
                    {{ $proposal->messages->count() }} PESAN
                </span>
            </div>

            <div class="border border-slate-700 rounded-2xl bg-slate-900/50 p-4 sm:p-6 h-[420px] scroll-smooth overflow-y-auto space-y-5 shadow-inner">
                @forelse($proposal->messages->sortBy('created_at') as $message)
                    @php $isMine = auth()->id() === $message->user_id; @endphp

                    <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[85%] sm:max-w-[70%]">
                            <div class="rounded-2xl px-5 py-4 shadow-sm {{ $isMine ? 'bg-cyan-600 border border-cyan-500 text-white rounded-br-sm shadow-cyan-900/50' : 'bg-slate-800 border border-slate-700 text-slate-200 rounded-bl-sm shadow-slate-900/50' }}">
                                <div class="flex items-center justify-between gap-4 mb-2">
                                    <span class="text-xs font-bold uppercase tracking-wider {{ $isMine ? 'text-cyan-100' : 'text-slate-400' }}">
                                        {{ $message->user?->name ?? 'User' }}
                                    </span>
                                    <span class="text-[10px] {{ $isMine ? 'text-cyan-200' : 'text-slate-500' }}">
                                        {{ $message->created_at->format('d-m-Y H:i') }}
                                    </span>
                                </div>
                                <div class="text-[13px] border-t {{ $isMine ? 'border-cyan-500/50' : 'border-slate-700' }} pt-2.5 whitespace-pre-line leading-relaxed">
                                    {{ $message->message }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-slate-500 opacity-40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-sm font-medium">Belum ada diskusi untuk proposal ini.</p>
                    </div>
                @endforelse
            </div>

            <form action="{{ route('proposals.messages.store', $proposal->id) }}" method="POST" class="mt-5">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <textarea name="message" rows="2" required
                            class="w-full border border-slate-700 bg-[#111827] text-white placeholder-slate-400 rounded-2xl px-5 py-3.5 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 resize-none transition-colors"
                            placeholder="Ketik pesan koordinasi Anda..."></textarea>
                    </div>

                    <button type="submit"
                        class="shrink-0 flex items-center justify-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg shadow-cyan-500/25 transition">
                        <span>Kirim</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
        .animate-fadeIn { animation: fadeIn 0.4s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
@endsection