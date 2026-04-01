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
                        Selamat datang, {{ auth()->user()->name ?? 'Super Admin' }}
                    </p>
                </div>


            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                <div
                    class="rounded-2xl border border-cyan-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(59,130,246,0.12)]">
                    <p class="text-sm text-slate-400">Total Desa</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $totalVillages }}</h3>
                </div>

                <div
                    class="rounded-2xl border border-blue-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(59,130,246,0.12)]">
                    <p class="text-sm text-slate-400">Total Organisasi</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $totalOrganizations }}</h3>
                </div>

                <div
                    class="rounded-2xl border border-purple-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(168,85,247,0.15)]">
                    <p class="text-sm text-slate-400">Total Anggota</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $totalMembers }}</h3>
                </div>

                <div
                    class="rounded-2xl border border-pink-400/20 bg-[#0b1220]/90 p-5 shadow-[0_0_25px_rgba(236,72,153,0.14)]">
                    <p class="text-sm text-slate-400">Total User</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $totalUsers }}</h3>
                </div>
            </div>

            {{-- Welcome Card --}}
            <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                <h3 class="text-xl font-semibold text-white mb-3">Selamat Datang</h3>
                <p class="text-slate-300 leading-relaxed">
                    Anda login sebagai <span class="font-semibold text-cyan-400">Super Admin</span>.
                    Dari dashboard ini Anda dapat mengelola data desa, organisasi, anggota, kegiatan,
                    kas, proposal, dan laporan dalam satu sistem yang terintegrasi.
                </p>
            </div>

            {{-- Quick Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-white mb-4">Ringkasan Sistem</h3>
                    <div class="space-y-3 text-slate-300">
                        <div class="flex items-center justify-between border-b border-slate-700/50 pb-3">
                            <span>Data Desa</span>
                            <span class="font-semibold text-cyan-400">{{ $totalVillages }}</span>
                        </div>
                        <div class="flex items-center justify-between border-b border-slate-700/50 pb-3">
                            <span>Data Organisasi</span>
                            <span class="font-semibold text-blue-400">{{ $totalOrganizations }}</span>
                        </div>
                        <div class="flex items-center justify-between border-b border-slate-700/50 pb-3">
                            <span>Data Anggota</span>
                            <span class="font-semibold text-purple-400">{{ $totalMembers }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Data User</span>
                            <span class="font-semibold text-pink-400">{{ $totalUsers }}</span>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-white mb-4">Akses Super Admin</h3>
                    <p class="text-slate-300 mb-4">
                        Super Admin memiliki akses penuh untuk memantau dan mengelola seluruh data utama sistem.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <span class="rounded-full bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 px-4 py-2 text-sm">
                            Kelola Desa
                        </span>
                        <span class="rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30 px-4 py-2 text-sm">
                            Kelola Organisasi
                        </span>
                        <span
                            class="rounded-full bg-purple-500/20 text-purple-400 border border-purple-500/30 px-4 py-2 text-sm">
                            Kelola Anggota
                        </span>
                        <span class="rounded-full bg-pink-500/20 text-pink-400 border border-pink-500/30 px-4 py-2 text-sm">
                            Kelola User
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection