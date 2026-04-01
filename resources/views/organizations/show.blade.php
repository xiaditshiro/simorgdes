@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white">Detail Organisasi</h2>
                <p class="text-slate-400 mt-1">Informasi lengkap organisasi.</p>
            </div>

            <a href="{{ route('organizations.index') }}"
                class="rounded-xl bg-slate-700 px-5 py-3 text-sm text-white hover:bg-slate-600 transition">
                ← Kembali
            </a>
        </div>

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6 space-y-4">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <p class="text-sm text-slate-400">Desa</p>
                    <p class="text-white font-semibold">
                        {{ $organization->village?->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Nama Organisasi</p>
                    <p class="text-white font-semibold">
                        {{ $organization->name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Jenis</p>
                    <p class="text-white font-semibold">
                        {{ $organization->type ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Tanggal Berdiri</p>
                    <p class="text-white font-semibold">
                        {{ $organization->established_date?->format('d-m-Y') ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Telepon</p>
                    <p class="text-white font-semibold">
                        {{ $organization->phone ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Email</p>
                    <p class="text-white font-semibold">
                        {{ $organization->email ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Ketua</p>
                    <p class="text-white font-semibold">
                        {{ $organization->leader_name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Sekretaris</p>
                    <p class="text-white font-semibold">
                        {{ $organization->secretary_name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Bendahara</p>
                    <p class="text-white font-semibold">
                        {{ $organization->treasurer_name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Status</p>

                    @if($organization->status === 'aktif')
                        <span
                            class="inline-block rounded-full bg-emerald-500/20 text-emerald-400 px-3 py-1 text-xs font-semibold border border-emerald-500/30">
                            Aktif
                        </span>
                    @else
                        <span
                            class="inline-block rounded-full bg-rose-500/20 text-rose-400 px-3 py-1 text-xs font-semibold border border-rose-500/30">
                            Nonaktif
                        </span>
                    @endif

                </div>

            </div>

            <div class="pt-4 border-t border-slate-700">
                <p class="text-sm text-slate-400 mb-2">Alamat</p>

                <p class="text-slate-200 leading-relaxed">
                    {{ $organization->address ?? '-' }}
                </p>
            </div>

        </div>

    </div>

@endsection