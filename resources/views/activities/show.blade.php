@extends('layouts.app')

@section('content')

    <div class="max-w-3xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white">Detail Kegiatan</h2>
                <p class="text-slate-400 mt-1">Informasi lengkap kegiatan organisasi.</p>
            </div>

            <a href="{{ route('activities.index') }}"
                class="rounded-xl bg-slate-700 px-5 py-3 text-sm text-white hover:bg-slate-600 transition">
                Kembali
            </a>
        </div>

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6 space-y-4">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <p class="text-sm text-slate-400">Organisasi</p>
                    <p class="text-white font-semibold">
                        {{ $activity->organization?->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Judul</p>
                    <p class="text-white font-semibold">
                        {{ $activity->title }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Tanggal</p>
                    <p class="text-white font-semibold">
                        {{ $activity->activity_date }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Lokasi</p>
                    <p class="text-white font-semibold">
                        {{ $activity->location }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Status</p>

                    <span class="
                        px-3 py-1 rounded text-sm font-medium
                        {{ $activity->status == 'completed' ? 'bg-green-500/20 text-green-400' : '' }}
                        {{ $activity->status == 'scheduled' ? 'bg-blue-500/20 text-blue-400' : '' }}
                        {{ $activity->status == 'draft' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                        {{ $activity->status == 'cancelled' ? 'bg-red-500/20 text-red-400' : '' }}
                    ">
                        {{ ucfirst($activity->status) }}
                    </span>

                </div>

            </div>

            <div class="pt-4 border-t border-slate-700">
                <p class="text-sm text-slate-400 mb-2">Deskripsi</p>

                <p class="text-slate-200 leading-relaxed">
                    {{ $activity->description ?? '-' }}
                </p>
            </div>

        </div>

    </div>

@endsection