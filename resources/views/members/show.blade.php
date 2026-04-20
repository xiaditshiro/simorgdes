@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header Section --}}
        <div>
            
            <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight">Detail Anggota</h2>
            <p class="text-sm text-slate-400 mt-1.5">Informasi lengkap terkait keanggotaan organisasi.</p>
        </div>

        {{-- Card Container --}}
        <div class="rounded-3xl border border-slate-700/60 bg-gradient-to-b from-[#0b1220] to-[#070c16] shadow-2xl overflow-hidden">
            
            {{-- Top Banner / Profile Indicator --}}
            

            <div class="px-6 sm:px-10 pt-14 sm:pt-16 pb-8 sm:pb-10 space-y-8">
            
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold text-white">{{ $member->full_name ?? '-' }}</h3>
                        <p class="text-cyan-400 font-medium text-sm sm:text-base mt-1">{{ ucfirst($member->position ?? 'Anggota') }}</p>
                    </div>

                    @if($member->status === 'aktif')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1.5 text-xs sm:text-sm font-semibold text-emerald-400 border border-emerald-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                        </span>
                    @elseif($member->status === 'nonaktif')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-500/10 px-3 py-1.5 text-xs sm:text-sm font-semibold text-rose-400 border border-rose-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Nonaktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-500/10 px-3 py-1.5 text-xs sm:text-sm font-semibold text-slate-400 border border-slate-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> {{ ucfirst($member->status ?? '-') }}
                        </span>
                    @endif
                </div>

                {{-- User Data Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">

                    {{-- NIK --}}
                    <div class="bg-slate-800/40 rounded-2xl p-4 sm:p-5 border border-slate-700/50 hover:bg-slate-800/70 transition-colors">
                        <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold mb-1.5">NIK</p>
                        <p class="text-slate-200 font-medium break-words">{{ $member->nik ?? '-' }}</p>
                    </div>

                    {{-- Organisasi --}}
                    <div class="bg-slate-800/40 rounded-2xl p-4 sm:p-5 border border-slate-700/50 hover:bg-slate-800/70 transition-colors">
                        <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold mb-1.5">Organisasi</p>
                        <p class="text-slate-200 font-medium">{{ $member->organization?->name ?? '-' }}</p>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="bg-slate-800/40 rounded-2xl p-4 sm:p-5 border border-slate-700/50 hover:bg-slate-800/70 transition-colors">
                        <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold mb-1.5">Jenis Kelamin</p>
                        <p class="text-slate-200 font-medium">
                            @if($member->gender === 'L')
                                Laki-laki
                            @elseif($member->gender === 'P')
                                Perempuan
                            @else
                                -
                            @endif
                        </p>
                    </div>

                    {{-- TTL --}}
                    <div class="bg-slate-800/40 rounded-2xl p-4 sm:p-5 border border-slate-700/50 hover:bg-slate-800/70 transition-colors">
                        <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold mb-1.5">Tempat, Tanggal Lahir</p>
                        <p class="text-slate-200 font-medium">
                            {{ $member->birth_place ?? '-' }}, {{ $member->birth_date?->format('d M Y') ?? '-' }}
                        </p>
                    </div>

                    {{-- No HP --}}
                    <div class="bg-slate-800/40 rounded-2xl p-4 sm:p-5 border border-slate-700/50 hover:bg-slate-800/70 transition-colors">
                        <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold mb-1.5">No Handphone</p>
                        <p class="text-slate-200 font-medium">{{ $member->phone ?? '-' }}</p>
                    </div>

                    {{-- Tanggal Bergabung --}}
                    <div class="bg-slate-800/40 rounded-2xl p-4 sm:p-5 border border-slate-700/50 hover:bg-slate-800/70 transition-colors">
                        <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold mb-1.5">Tanggal Bergabung</p>
                        <p class="text-slate-200 font-medium">{{ $member->join_date?->format('d M Y') ?? '-' }}</p>
                    </div>

                    {{-- Alamat (Spans Full Width) --}}
                    <div class="sm:col-span-2 lg:col-span-3 bg-slate-800/40 rounded-2xl p-4 sm:p-5 border border-slate-700/50 hover:bg-slate-800/70 transition-colors">
                        <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold mb-1.5">Alamat Lengkap</p>
                        <p class="text-slate-200 font-medium leading-relaxed">{{ $member->address ?? '-' }}</p>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="pt-6 border-t border-slate-700/60 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('members.edit', $member->id) }}"
                        class="flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500 px-6 py-3 text-sm font-semibold text-white hover:opacity-90 transition shadow-lg shadow-cyan-500/25 w-full sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Anggota
                    </a>

                    <a href="{{ route('members.index') }}"
                        class="flex items-center justify-center rounded-xl bg-slate-800 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-700 transition border border-slate-700 shadow-sm w-full sm:w-auto mt-2 sm:mt-0">
                        Kembali ke Daftar
                    </a>
                </div>

            </div>
        </div>

    </div>

@endsection