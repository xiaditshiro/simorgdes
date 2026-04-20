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

        </div>

        {{-- Analytics Overview --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            {{-- Line Chart: Income vs Expense --}}
            <div class="xl:col-span-2 rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-white">Trend Arus Kas (6 Bulan Terakhir)</h3>
                    <div class="flex items-center gap-4 text-xs">
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-cyan-500"></span>
                            <span class="text-slate-400">Kas Masuk</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <span class="text-slate-400">Kas Keluar</span>
                        </div>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="canvasFinancialTrend"></canvas>
                </div>
            </div>

            {{-- Pie Chart: Cash Discipline --}}
            <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-6">Kedisiplinan Bayar Kas</h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="canvasCashDiscipline"></canvas>
                </div>
                <div class="mt-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Lunas</span>
                        <span class="text-emerald-400 font-semibold">{{ $totalPaid }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Belum Bayar</span>
                        <span class="text-rose-400 font-semibold">{{ $totalUnpaid }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            {{-- Pie Chart: Expense Composition --}}
            <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-6">Alokasi Pengeluaran</h3>
                <div class="h-72 flex items-center justify-center">
                    <canvas id="canvasExpenseComposition"></canvas>
                </div>
            </div>

            {{-- Kendali Cepat --}}
            <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg flex flex-col justify-center">
                <h3 class="text-lg font-semibold text-white mb-4">Kendali Cepat Bendahara</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="{{ route('cash.index') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-[#0d1320] border border-slate-700/60 p-4 text-white font-medium hover:border-cyan-500/50 hover:bg-cyan-500/5 transition group">
                        <span class="group-hover:text-cyan-400 text-center">Input Kas Anggota</span>
                    </a>
                    <a href="{{ route('finance.create') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-[#0d1320] border border-slate-700/60 p-4 text-white font-medium hover:border-emerald-500/50 hover:bg-emerald-500/5 transition group">
                        <span class="group-hover:text-emerald-400 text-center">Catat Pengeluaran</span>
                    </a>
                    <a href="{{ route('finance.index') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-[#0d1320] border border-slate-700/60 p-4 text-white font-medium hover:border-blue-500/50 hover:bg-blue-500/5 transition group">
                        <span class="group-hover:text-blue-400 text-center">Riwayat Keuangan</span>
                    </a>
                    <a href="{{ route('finance.categories') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-[#0d1320] border border-slate-700/60 p-4 text-white font-medium hover:border-purple-500/50 hover:bg-purple-500/5 transition group">
                        <span class="group-hover:text-purple-400 text-center">Kategori Keuangan</span>
                    </a>
                </div>
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


    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.font.family = 'Inter, sans-serif';

    // 1. Line Chart: Financial Trend
    const ctxTrend = document.getElementById('canvasFinancialTrend').getContext('2d');
    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: @json($chartMonthlyLabels),
            datasets: [
                {
                    label: 'Kas Masuk',
                    data: @json($chartMonthlyIncome),
                    borderColor: '#06b6d4',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#06b6d4',
                    pointBorderColor: '#0b1220',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                },
                {
                    label: 'Kas Keluar',
                    data: @json($chartMonthlyExpense),
                    borderColor: '#f43f5e',
                    backgroundColor: 'rgba(244, 63, 94, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#f43f5e',
                    pointBorderColor: '#0b1220',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(51, 65, 85, 0.1)' },
                    ticks: { callback: v => 'Rp ' + v.toLocaleString() }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Doughnut Chart: Cash Discipline
    const ctxDiscipline = document.getElementById('canvasCashDiscipline').getContext('2d');
    new Chart(ctxDiscipline, {
        type: 'doughnut',
        data: {
            labels: ['Lunas', 'Belum Bayar'],
            datasets: [{
                data: @json($chartDisciplineData),
                backgroundColor: ['#10b981', '#f43f5e'],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });

    // 3. Pie Chart: Expense Composition
    const ctxExpense = document.getElementById('canvasExpenseComposition').getContext('2d');
    new Chart(ctxExpense, {
        type: 'pie',
        data: {
            labels: @json($chartExpenseLabels),
            datasets: [{
                data: @json($chartExpenseData),
                backgroundColor: ['#3b82f6', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981', '#6366f1'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right', labels: { padding: 20 } }
            }
        }
    });
</script>
@endpush