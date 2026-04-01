@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">Tambah Data Desa</h2>
                <p class="text-slate-400 mt-1">Tambahkan data desa baru ke dalam sistem.</p>
            </div>

            <a href="{{ route('villages.index') }}"
                class="inline-flex items-center justify-center rounded-xl bg-slate-700 hover:bg-slate-600 px-5 py-3 text-sm font-medium text-white transition">
                ← Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-4 py-4 text-rose-400 shadow-lg">
                <p class="font-semibold mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc ml-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6 md:p-8">
            <form action="{{ route('villages.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-300">Nama Desa</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-300">Kecamatan</label>
                        <input type="text" name="district" value="{{ old('district') }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-300">Kabupaten</label>
                        <input type="text" name="regency" value="{{ old('regency') }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-300">Provinsi</label>
                        <input type="text" name="province" value="{{ old('province') }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-300">Kode Pos</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-300">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-slate-300">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-slate-300">Alamat</label>
                        <textarea name="address" rows="4"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="pt-4 flex flex-wrap gap-3">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                        Simpan
                    </button>

                    <a href="{{ route('villages.index') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-slate-700 hover:bg-slate-600 px-6 py-3 text-sm font-medium text-white transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>

@endsection