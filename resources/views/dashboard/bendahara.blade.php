@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#070b14] text-white">
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">
                    Dashboard Bendahara
                </h2>
                <p class="text-slate-400 mt-1">
                    Selamat datang, {{ auth()->user()->name }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative">
                    <input type="text" placeholder="Cari data..."
                        class="bg-[#0d1320] border border-slate-700/60 text-slate-200 placeholder-slate-500 rounded-xl px-4 py-3 w-64 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                </div>
            </div>
        </div>

        {{-- Informasi Organisasi --}}
        <div class="rounded-2xl border border-cyan-500/20 bg-[#0b1220]/90 shadow-[0_0_30px_rgba(34,211,238,0.08)] p-6">
            <h3 class="text-lg font-semibold text-white mb-3">Informasi Organisasi</h3>
            <p class="text-slate-300">
                <span class="font-semibold text-slate-100">Nama Organisasi:</span>
                {{ $organization?->name ?? '-' }}
            </p>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="rounded-2xl border border-cyan-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(59,130,246,0.12)]">
                <p class="text-sm text-slate-400">Total Anggota</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ $totalMembers }}</h3>
            </div>

            <div class="rounded-2xl border border-yellow-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(250,204,21,0.10)]">
                <p class="text-sm text-slate-400">Grup Kas</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ $totalCashGroups }}</h3>
            </div>

            <div class="rounded-2xl border border-blue-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(59,130,246,0.12)]">
                <p class="text-sm text-slate-400">Total Jadwal Kas</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ $totalSchedules }}</h3>
            </div>

            <div class="rounded-2xl border border-purple-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(168,85,247,0.15)]">
                <p class="text-sm text-slate-400">Kas Masuk</p>
                <h3 class="text-3xl font-bold text-white mt-2">
                    Rp {{ number_format($totalCashIn, 0, ',', '.') }}
                </h3>
            </div>
        </div>

        {{-- Status Ringkas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="rounded-2xl border border-emerald-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(16,185,129,0.15)]">
                <p class="text-sm text-slate-400">Pembayaran Lunas</p>
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
                <a href="{{ route('cash.index') }}"
                    class="inline-flex items-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-white font-medium shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                    Kelola Kas Anggota
                </a>
            </div>
        </div>

        {{-- Status Kas Saya --}}
        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-white mb-4">Status Kas Saya</h3>

            @if(!$myMember)
                <p class="text-slate-400">Akun ini belum terhubung dengan data anggota.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                    <div class="rounded-2xl border border-cyan-400/20 bg-[#0f172a]/90 p-5">
                        <p class="text-sm text-slate-400">Total Tagihan Kas Saya</p>
                        <h3 class="text-3xl font-bold text-white mt-2">{{ $myTotalPayments }}</h3>
                    </div>

                    <div class="rounded-2xl border border-emerald-400/20 bg-[#0f172a]/90 p-5">
                        <p class="text-sm text-slate-400">Sudah Bayar</p>
                        <h3 class="text-3xl font-bold text-emerald-400 mt-2">{{ $myTotalPaid }}</h3>
                    </div>

                    <div class="rounded-2xl border border-rose-400/20 bg-[#0f172a]/90 p-5">
                        <p class="text-sm text-slate-400">Belum Bayar</p>
                        <h3 class="text-3xl font-bold text-rose-400 mt-2">{{ $myTotalUnpaid }}</h3>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-3">Kas Saya Terbaru</h4>

                    @if($myLatestPayments->count())
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
                                    @foreach($myLatestPayments as $payment)
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
                        <p class="text-slate-400">Belum ada data kas saya.</p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Kas Terbaru --}}
        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-white mb-4">Kas Terbaru</h3>

            @if($latestCashGroups->count())
                <div class="overflow-x-auto rounded-2xl border border-slate-700/50">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-[#111827] text-slate-300">
                            <tr>
                                <th class="px-4 py-4">Judul Kas</th>
                                <th class="px-4 py-4">Jumlah</th>
                                <th class="px-4 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#0b1220] text-slate-200">
                            @foreach($latestCashGroups as $cash)
                                <tr class="border-t border-slate-700/50 hover:bg-slate-800/30 transition">
                                    <td class="px-4 py-4">{{ $cash->title }}</td>
                                    <td class="px-4 py-4">Rp {{ number_format($cash->amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4">
                                        <a href="{{ route('cash.show', $cash->id) }}"
                                            class="inline-block rounded-lg bg-slate-700 hover:bg-slate-600 px-4 py-2 text-white text-sm transition">
                                            Detail
                                        </a>
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

        {{-- Riwayat Pembayaran Terbaru --}}
        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-white mb-4">Riwayat Pembayaran Terbaru</h3>

            @if($latestCashPayments->count())
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
                            @foreach($latestCashPayments as $payment)
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

    </div>
</div>
@endsection