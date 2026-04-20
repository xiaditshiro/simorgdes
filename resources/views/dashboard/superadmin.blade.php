@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#070b14] text-white">
        <div class="space-y-6">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-wide text-white">
                        Dashboard Super Admin
                    </h2>
                    <p class="text-slate-400 mt-1">
                        Ringkasan statistik dan aktivitas sistem secara keseluruhan.
                    </p>
                </div>
                
                {{-- Quick Actions --}}
                <div class="flex gap-3">
                    <a href="{{ route('villages.index') ?? '#' }}" class="rounded-full bg-cyan-500 hover:bg-cyan-600 text-white px-5 py-2 text-sm font-semibold transition shadow-lg shadow-cyan-500/30 flex items-center justify-center">
                        Kelola Desa
                    </a>
                    <a href="{{ route('organizations.index') ?? '#' }}" class="rounded-full bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 text-sm font-semibold transition shadow-lg shadow-blue-500/30 flex items-center justify-center">
                        Kelola Organisasi
                    </a>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                <div
                    class="rounded-2xl border border-cyan-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(59,130,246,0.12)] hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-slate-400">Total Desa</p>
                            <h3 class="text-3xl font-bold text-white mt-1">{{ $totalVillages }}</h3>
                        </div>
                        <div class="p-3 bg-cyan-500/10 rounded-xl text-cyan-400">
                            {{-- Icon SVG --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"></path></svg>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-blue-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(59,130,246,0.12)] hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-slate-400">Total Organisasi</p>
                            <h3 class="text-3xl font-bold text-white mt-1">{{ $totalOrganizations }}</h3>
                        </div>
                        <div class="p-3 bg-blue-500/10 rounded-xl text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-pink-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(236,72,153,0.14)] hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-slate-400">Total User</p>
                            <h3 class="text-3xl font-bold text-white mt-1">{{ $totalUsers }}</h3>
                        </div>
                        <div class="p-3 bg-pink-500/10 rounded-xl text-pink-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-orange-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(251,146,60,0.14)] hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-slate-400">Total Proposal</p>
                            <h3 class="text-3xl font-bold text-white mt-1">{{ $totalProposals }}</h3>
                        </div>
                        <div class="p-3 bg-orange-500/10 rounded-xl text-orange-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Left: Chart (2 cols) --}}
                <div class="lg:col-span-2 rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-white mb-6">Sebaran Organisasi per Desa</h3>
                    <div class="relative h-[300px] w-full">
                        <canvas id="organizationChart"></canvas>
                    </div>
                </div>

                {{-- Right: Recent Activities (1 col) --}}
                <div class="space-y-6">
                    
                    {{-- Terbaru --}}
                    <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                        <h3 class="text-lg font-semibold text-white mb-4">Desa Terbaru Ditambahkan</h3>
                        <div class="space-y-4">
                            @forelse($recentVillages as $village)
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 flex-shrink-0 flex items-center justify-center rounded-full bg-cyan-500/10 text-cyan-400 border border-cyan-500/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"></path></svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-white truncate">{{ $village->name }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $village->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 text-center py-4">Belum ada desa terdaftar.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                        <h3 class="text-lg font-semibold text-white mb-4">Organisasi Terbaru</h3>
                        <div class="space-y-4">
                            @forelse($recentOrganizations as $org)
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 flex-shrink-0 flex items-center justify-center rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-white truncate">{{ $org->name }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $org->village->name ?? 'Tanpa Desa' }} • {{ $org->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 text-center py-4">Belum ada organisasi terdaftar.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Script for Chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('organizationChart');
            if (!ctx) return;
            
            const labels = {!! json_encode($chartLabels) !!};
            const dataCounts = {!! json_encode($chartData) !!};
            
            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Organisasi',
                        data: dataCounts,
                        backgroundColor: 'rgba(59, 130, 246, 0.4)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                        hoverBackgroundColor: 'rgba(34, 211, 238, 0.6)',
                        hoverBorderColor: 'rgba(34, 211, 238, 1)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(51, 65, 85, 0.5)',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#94a3b8',
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(51, 65, 85, 0.3)',
                                borderDash: [5, 5]
                            }
                        },
                        x: {
                            ticks: {
                                color: '#94a3b8'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection