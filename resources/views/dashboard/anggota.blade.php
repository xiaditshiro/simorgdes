@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#070b14] text-white">
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">
                    Dashboard Anggota
                </h2>
                <p class="text-slate-400 mt-1">
                    Selamat datang, {{ auth()->user()->name }}
                </p>
            </div>

            <div class="w-full md:w-auto">
                <input type="text" placeholder="Cari data..."
                    class="w-full md:w-72 bg-[#0d1320] border border-slate-700/60 text-slate-200 placeholder-slate-500 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
        </div>

        @if(!$member)
            <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 text-rose-400 shadow-lg p-6">
                Akun ini belum terhubung dengan data anggota.
            </div>
        @else

            {{-- Informasi Anggota --}}
            <div class="rounded-2xl border border-cyan-500/20 bg-[#0b1220]/90 shadow-[0_0_30px_rgba(34,211,238,0.08)] p-6">
                <h3 class="text-lg font-semibold text-white mb-3">Informasi Anggota</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-slate-300">
                    <p><span class="font-semibold text-white">Nama:</span> {{ $member->full_name }}</p>
                    <p><span class="font-semibold text-white">Organisasi:</span> {{ $organization?->name ?? '-' }}</p>
                    <p><span class="font-semibold text-white">Jabatan:</span> {{ ucfirst($member->position) }}</p>
                    <p><span class="font-semibold text-white">Status:</span> {{ ucfirst($member->status) }}</p>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="rounded-2xl border border-cyan-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(59,130,246,0.12)]">
                    <p class="text-sm text-slate-400">Total Tagihan Kas</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $totalPayments }}</h3>
                </div>

                <div class="rounded-2xl border border-emerald-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(16,185,129,0.15)]">
                    <p class="text-sm text-slate-400">Sudah Bayar</p>
                    <h3 class="text-3xl font-bold text-emerald-400 mt-2">{{ $totalPaid }}</h3>
                </div>

                <div class="rounded-2xl border border-rose-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(244,63,94,0.12)]">
                    <p class="text-sm text-slate-400">Belum Bayar</p>
                    <h3 class="text-3xl font-bold text-rose-400 mt-2">{{ $totalUnpaid }}</h3>
                </div>
            </div>

            {{-- Akses Cepat --}}
            <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Akses Cepat</h3>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('cash.my') }}"
                        class="inline-flex items-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-white font-medium shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                        Lihat Kas Saya
                    </a>

                    <a href="{{ route('attendance.my-qr') }}"
                        class="inline-flex items-center rounded-xl bg-gradient-to-r from-emerald-500 to-green-600 px-5 py-3 text-white font-medium shadow-[0_0_25px_rgba(16,185,129,0.30)] hover:scale-[1.02] transition">
                        Tampilkan QR Absensi
                    </a>
                </div>
            </div>

            {{-- Kas Terbaru --}}
            <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Kas Terbaru</h3>

                @if($latestPayments->count())
                    <div class="overflow-x-auto rounded-2xl border border-slate-700/50">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-[#111827] text-slate-300">
                                <tr>
                                    <th class="px-4 py-4">Judul Kas</th>
                                    <th class="px-4 py-4">Tanggal</th>
                                    <th class="px-4 py-4">Jumlah</th>
                                    <th class="px-4 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[#0b1220] text-slate-200">
                                @foreach($latestPayments as $payment)
                                    <tr class="border-t border-slate-700/50 hover:bg-slate-800/30 transition">
                                        <td class="px-4 py-4">{{ $payment->schedule?->group?->title ?? '-' }}</td>
                                        <td class="px-4 py-4">
                                            {{ $payment->schedule?->due_date?->format('d-m-Y') ?? '-' }}
                                        </td>
                                        <td class="px-4 py-4">
                                            Rp {{ number_format($payment->schedule?->group?->amount ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($payment->status === 'paid')
                                                <span class="inline-block rounded-full bg-emerald-500/20 text-emerald-400 px-3 py-1 text-xs font-semibold border border-emerald-500/30">
                                                    Sudah Bayar
                                                </span>
                                            @else
                                                <span class="inline-block rounded-full bg-rose-500/20 text-rose-400 px-3 py-1 text-xs font-semibold border border-rose-500/30">
                                                    Belum Bayar
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-slate-400">Belum ada data kas.</p>
                @endif
            </div>

            {{-- Kegiatan Terbaru --}}
            <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Kegiatan Terbaru Organisasi</h3>

                @forelse($latestActivities as $activity)
                    <div class="border-b border-slate-700/50 py-3">
                        <div class="font-semibold text-white">
                            {{ $activity->title }}
                        </div>

                        <div class="text-sm text-slate-400">
                            Tanggal: {{ $activity->activity_date }}
                        </div>

                        <div class="mt-2">
                            @if($activity->status === 'selesai')
                                <span class="inline-block rounded-full bg-emerald-500/20 text-emerald-400 px-3 py-1 text-xs font-semibold border border-emerald-500/30">
                                    {{ ucfirst($activity->status) }}
                                </span>
                            @elseif($activity->status === 'berlangsung')
                                <span class="inline-block rounded-full bg-blue-500/20 text-blue-400 px-3 py-1 text-xs font-semibold border border-blue-500/30">
                                    {{ ucfirst($activity->status) }}
                                </span>
                            @else
                                <span class="inline-block rounded-full bg-yellow-500/20 text-yellow-400 px-3 py-1 text-xs font-semibold border border-yellow-500/30">
                                    {{ ucfirst($activity->status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400">Belum ada kegiatan terbaru.</p>
                @endforelse
            </div>

        @endif
    </div>
</div>
@endsection