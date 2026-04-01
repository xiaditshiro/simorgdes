@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white">Edit Data Organisasi</h2>
                <p class="text-slate-400 mt-1">Perbarui informasi organisasi.</p>
            </div>

            <a href="{{ route('organizations.index') }}"
                class="rounded-xl bg-slate-700 px-5 py-3 text-sm text-white hover:bg-slate-600 transition">
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

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6">

            <form action="{{ route('organizations.update', $organization->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Desa</label>
                    <select name="village_id"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white">
                        <option value="">-- Pilih Desa --</option>
                        @foreach($villages as $village)
                            <option value="{{ $village->id }}" {{ old('village_id', $organization->village_id) == $village->id ? 'selected' : '' }}>
                                {{ $village->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Nama Organisasi</label>
                    <input type="text" name="name" value="{{ old('name', $organization->name) }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Jenis Organisasi</label>
                    <input type="text" name="type" value="{{ old('type', $organization->type) }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Tanggal Berdiri</label>
                    <input type="date" name="established_date"
                        value="{{ old('established_date', $organization->established_date?->format('Y-m-d')) }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Alamat</label>
                    <textarea name="address"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white">{{ old('address', $organization->address) }}</textarea>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $organization->phone) }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Email</label>
                    <input type="email" name="email" value="{{ old('email', $organization->email) }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Nama Ketua</label>
                    <input type="text" name="leader_name" value="{{ old('leader_name', $organization->leader_name) }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Nama Sekretaris</label>
                    <input type="text" name="secretary_name"
                        value="{{ old('secretary_name', $organization->secretary_name) }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Nama Bendahara</label>
                    <input type="text" name="treasurer_name"
                        value="{{ old('treasurer_name', $organization->treasurer_name) }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Status</label>
                    <select name="status"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white">
                        <option value="aktif" {{ old('status', $organization->status) == 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="nonaktif" {{ old('status', $organization->status) == 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                </div>

                <div class="pt-4 flex gap-3">
                    <button
                        class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-sm text-white hover:scale-[1.02] transition">
                        Update
                    </button>

                    <a href="{{ route('organizations.index') }}"
                        class="rounded-xl bg-slate-700 px-5 py-3 text-sm text-white hover:bg-slate-600 transition">
                        Batal
                    </a>
                </div>

            </form>

        </div>

    </div>

@endsection