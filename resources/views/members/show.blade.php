@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white">Detail Anggota</h2>
                <p class="text-slate-400 mt-1">Informasi lengkap anggota organisasi.</p>
            </div>

            <a href="{{ route('members.index') }}"
                class="rounded-xl bg-slate-700 px-5 py-3 text-sm text-white hover:bg-slate-600 transition">
                ← Kembali
            </a>
        </div>

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6 space-y-4">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <p class="text-sm text-slate-400">Nama Lengkap</p>
                    <p class="text-white font-semibold">
                        {{ $member->full_name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Organisasi</p>
                    <p class="text-white font-semibold">
                        {{ $member->organization?->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">NIK</p>
                    <p class="text-white font-semibold">
                        {{ $member->nik ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Jenis Kelamin</p>
                    <p class="text-white font-semibold">
                        @if($member->gender === 'L')
                            Laki-laki
                        @elseif($member->gender === 'P')
                            Perempuan
                        @else
                            -
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Tempat Lahir</p>
                    <p class="text-white font-semibold">
                        {{ $member->birth_place ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Tanggal Lahir</p>
                    <p class="text-white font-semibold">
                        {{ $member->birth_date?->format('d-m-Y') ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">No HP</p>
                    <p class="text-white font-semibold">
                        {{ $member->phone ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Jabatan</p>
                    <p class="text-white font-semibold">
                        {{ ucfirst($member->position ?? '-') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Tanggal Bergabung</p>
                    <p class="text-white font-semibold">
                        {{ $member->join_date?->format('d-m-Y') ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-400">Status</p>

                    @if($member->status === 'aktif')
                        <span
                            class="inline-block rounded-full bg-emerald-500/20 text-emerald-400 px-3 py-1 text-xs font-semibold border border-emerald-500/30">
                            Aktif
                        </span>
                    @elseif($member->status === 'nonaktif')
                        <span
                            class="inline-block rounded-full bg-rose-500/20 text-rose-400 px-3 py-1 text-xs font-semibold border border-rose-500/30">
                            Nonaktif
                        </span>
                    @else
                        <span
                            class="inline-block rounded-full bg-slate-500/20 text-slate-300 px-3 py-1 text-xs font-semibold border border-slate-500/30">
                            {{ ucfirst($member->status ?? '-') }}
                        </span>
                    @endif
                </div>

            </div>

            <div class="pt-4 border-t border-slate-700">
                <p class="text-sm text-slate-400 mb-2">Alamat</p>

                <p class="text-slate-200 leading-relaxed">
                    {{ $member->address ?? '-' }}
                </p>
            </div>

            <div class="pt-2 flex gap-3">
                <a href="{{ route('members.edit', $member->id) }}"
                    class="rounded-xl bg-yellow-500 px-5 py-3 text-sm text-white hover:bg-yellow-600 transition">
                    Edit
                </a>

                <a href="{{ route('members.index') }}"
                    class="rounded-xl bg-slate-700 px-5 py-3 text-sm text-white hover:bg-slate-600 transition">
                    Kembali
                </a>
            </div>

        </div>

    </div>

@endsection