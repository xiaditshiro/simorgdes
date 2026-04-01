@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <h2 class="text-3xl font-bold text-white">Edit Anggota</h2>
            <p class="text-slate-400">Perbarui data anggota organisasi.</p>
        </div>

        <div class="bg-[#0b1220] border border-slate-700/60 rounded-2xl shadow-xl p-8">
            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3">
                    <ul class="list-disc ml-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('members.update', $member->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-400">Organisasi</label>
                        <select name="organization_id"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                            <option value="">-- Pilih Organisasi --</option>
                            @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}"
                                    {{ old('organization_id', $member->organization_id) == $organization->id ? 'selected' : '' }}>
                                    {{ $organization->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-400">Jabatan</label>
                        <select name="position"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                            <option value="anggota" {{ old('position', $member->position) == 'anggota' ? 'selected' : '' }}>Anggota</option>
                            <option value="ketua" {{ old('position', $member->position) == 'ketua' ? 'selected' : '' }}>Ketua</option>
                            <option value="sekretaris" {{ old('position', $member->position) == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                            <option value="bendahara" {{ old('position', $member->position) == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-400">Nama Lengkap</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $member->full_name) }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-400">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" name="nik" value="{{ old('nik', $member->nik) }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-400">Jenis Kelamin</label>
                        <select name="gender"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('gender', $member->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $member->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-400">Tempat Lahir</label>
                        <input type="text" name="birth_place" value="{{ old('birth_place', $member->birth_place) }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-400">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $member->birth_date?->format('Y-m-d')) }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-400">Alamat</label>
                    <textarea name="address" rows="3"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">{{ old('address', $member->address) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-400">No HP / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $member->phone) }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-400">Tanggal Bergabung</label>
                        <input type="date" name="join_date" value="{{ old('join_date', $member->join_date?->format('Y-m-d')) }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-400">Status Anggota</label>
                        <select name="status"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                            <option value="aktif" {{ old('status', $member->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $member->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit"
                        class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-3 text-sm font-bold text-white shadow-[0_0_20px_rgba(59,130,246,0.3)] hover:scale-[1.02] active:scale-[0.98] transition-all">
                        Update Data
                    </button>

                    <a href="{{ route('members.index') }}"
                        class="rounded-xl bg-slate-800 border border-slate-700 px-8 py-3 text-sm font-bold text-slate-300 hover:bg-slate-700 hover:text-white transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection