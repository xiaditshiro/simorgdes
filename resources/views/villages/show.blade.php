@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">Detail Desa</h2>
                <p class="text-slate-400 mt-1">Lihat informasi lengkap data desa.</p>
            </div>

            <a href="{{ route('villages.index') }}"
                class="inline-flex items-center justify-center rounded-xl bg-slate-700 hover:bg-slate-600 px-5 py-3 text-sm font-medium text-white transition">
                ← Kembali
            </a>
        </div>

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Nama Desa</p>
                    <p class="text-white font-semibold">{{ $village->name ?? '-' }}</p>
                </div>

                <div class="rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Kecamatan</p>
                    <p class="text-white font-semibold">{{ $village->district ?? '-' }}</p>
                </div>

                <div class="rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Kabupaten</p>
                    <p class="text-white font-semibold">{{ $village->regency ?? '-' }}</p>
                </div>

                <div class="rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Provinsi</p>
                    <p class="text-white font-semibold">{{ $village->province ?? '-' }}</p>
                </div>

                <div class="rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Kode Pos</p>
                    <p class="text-white font-semibold">{{ $village->postal_code ?? '-' }}</p>
                </div>

                <div class="rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Telepon</p>
                    <p class="text-white font-semibold">{{ $village->phone ?? '-' }}</p>
                </div>

                <div class="md:col-span-2 rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Email</p>
                    <p class="text-white font-semibold">{{ $village->email ?? '-' }}</p>
                </div>

                <div class="md:col-span-2 rounded-xl border border-slate-700 bg-[#111827] p-4">
                    <p class="text-sm text-slate-400 mb-1">Alamat</p>
                    <p class="text-white font-semibold leading-relaxed">{{ $village->address ?? '-' }}</p>
                </div>

            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('villages.edit', $village->id) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-yellow-500 hover:bg-yellow-600 px-5 py-3 text-sm font-medium text-white transition">
                    Edit Data
                </a>

                <a href="{{ route('villages.index') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-slate-700 hover:bg-slate-600 px-5 py-3 text-sm font-medium text-white transition">
                    Kembali
                </a>
            </div>
        </div>

    </div>

@endsection