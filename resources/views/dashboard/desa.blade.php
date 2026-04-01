@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#070b14] text-white">
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">
                    Dashboard Admin Desa
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

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="rounded-2xl border border-cyan-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(59,130,246,0.12)]">
                <p class="text-sm text-slate-400">Total Organisasi</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ $totalOrganizations }}</h3>
            </div>

            <div class="rounded-2xl border border-blue-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(59,130,246,0.12)]">
                <p class="text-sm text-slate-400">Total Anggota</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ $totalMembers }}</h3>
            </div>

            <div class="rounded-2xl border border-yellow-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(250,204,21,0.10)]">
                <p class="text-sm text-slate-400">Total Kegiatan</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ $totalActivities }}</h3>
            </div>

            <div class="rounded-2xl border border-purple-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(168,85,247,0.15)]">
                <p class="text-sm text-slate-400">Total User</p>
                <h3 class="text-3xl font-bold text-white mt-2">{{ $totalUsers }}</h3>
            </div>
        </div>

        {{-- Akses Cepat --}}
        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-white mb-4">Akses Cepat</h3>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('organizations.index') }}"
                    class="inline-flex items-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-white font-medium shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                    Data Organisasi
                </a>

                <a href="{{ route('members.index') }}"
                    class="inline-flex items-center rounded-xl bg-gradient-to-r from-emerald-500 to-green-600 px-5 py-3 text-white font-medium shadow-[0_0_25px_rgba(16,185,129,0.30)] hover:scale-[1.02] transition">
                    Data Anggota
                </a>

                <a href="{{ route('activities.index') }}"
                    class="inline-flex items-center rounded-xl bg-gradient-to-r from-yellow-500 to-orange-500 px-5 py-3 text-white font-medium shadow-[0_0_25px_rgba(234,179,8,0.30)] hover:scale-[1.02] transition">
                    Kegiatan Organisasi
                </a>
            </div>
        </div>

        {{-- Organisasi Terbaru --}}
        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-white mb-4">Organisasi Terbaru</h3>

            @if($latestOrganizations->count())
                <div class="overflow-x-auto rounded-2xl border border-slate-700/50">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-[#111827] text-slate-300">
                            <tr>
                                <th class="px-4 py-4">Nama Organisasi</th>
                                <th class="px-4 py-4">Jenis</th>
                                <th class="px-4 py-4">Ketua</th>
                                <th class="px-4 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#0b1220] text-slate-200">
                            @foreach($latestOrganizations as $organization)
                                <tr class="border-t border-slate-700/50 hover:bg-slate-800/30 transition">
                                    <td class="px-4 py-4">{{ $organization->name }}</td>
                                    <td class="px-4 py-4">{{ $organization->type }}</td>
                                    <td class="px-4 py-4">{{ $organization->leader_name }}</td>
                                    <td class="px-4 py-4">
                                        @if($organization->status === 'active')
                                            <span class="inline-block rounded-full bg-emerald-500/20 text-emerald-400 px-3 py-1 text-xs font-semibold border border-emerald-500/30">
                                                Aktif
                                            </span>
                                        @elseif($organization->status === 'inactive')
                                            <span class="inline-block rounded-full bg-rose-500/20 text-rose-400 px-3 py-1 text-xs font-semibold border border-rose-500/30">
                                                Tidak Aktif
                                            </span>
                                        @else
                                            <span class="inline-block rounded-full bg-slate-500/20 text-slate-300 px-3 py-1 text-xs font-semibold border border-slate-500/30">
                                                {{ ucfirst($organization->status) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-slate-400">Belum ada data organisasi.</p>
            @endif
        </div>

    </div>
</div>
@endsection