@extends('layouts.app')

@section('content')

    <div class="max-w-xl mx-auto space-y-6">

        <div>
            <h2 class="text-3xl font-bold tracking-wide text-white">QR Absensi Saya</h2>
            <p class="text-slate-400 mt-1">Tunjukkan QR ini kepada petugas untuk melakukan absensi.</p>
        </div>

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6">

            <div class="space-y-2 mb-6">
                <p class="text-sm text-slate-400">Nama Anggota</p>
                <p class="text-lg font-semibold text-white">
                    {{ $member->full_name }}
                </p>
            </div>

            <div class="flex justify-center">
                <div class="bg-white p-4 rounded-xl shadow">
                    {!! QrCode::size(280)->generate($payload) !!}
                </div>
            </div>

            <p class="mt-6 text-sm text-center text-slate-400">
                QR berlaku singkat dan akan berubah saat halaman dibuka ulang.
            </p>

        </div>

    </div>

@endsection