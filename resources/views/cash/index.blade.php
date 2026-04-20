@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">Jadwal Kas</h2>
                <p class="text-slate-400 mt-1">Kelola jadwal pembayaran kas organisasi pada sistem.</p>
            </div>

            <a href="{{ route('cash.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                + Buat Jadwal Kas
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-emerald-400 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg overflow-hidden backdrop-blur-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#111827] text-slate-300">
                        <tr>
                            <th class="px-4 py-4">No</th>
                            <th class="px-4 py-4">Organisasi</th>
                            <th class="px-4 py-4">Judul Kas</th>
                            <th class="px-4 py-4">Jumlah</th>
                            <th class="px-4 py-4">Total Jadwal</th>
                            <th class="px-4 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#0b1220] text-slate-200">
                        @forelse($groups as $group)
                            <tr class="border-t border-slate-700/50 hover:bg-slate-800/30 transition">
                                <td class="px-4 py-4 text-slate-400 font-mono text-xs">{{ $loop->iteration }}</td>
                                <td class="px-4 py-4 text-slate-300">{{ $group->organization?->name }}</td>
                                <td class="px-4 py-4 font-medium text-white">{{ $group->title }}</td>
                                <td class="px-4 py-4 font-mono text-cyan-400">Rp {{ number_format($group->amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-4">
                                    <span class="inline-block rounded-full bg-blue-500/20 text-blue-400 px-3 py-1 text-xs font-semibold border border-blue-500/30">
                                        {{ $group->schedules->count() }} Jadwal
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('cash.show', $group->id) }}"
                                            class="w-20 inline-flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 px-3 py-2 text-[11px] font-bold text-white transition-all hover:scale-105 active:scale-95 border border-slate-600">
                                            Detail
                                        </a>

                                        <a href="{{ route('cash.edit', $group->id) }}"
                                            class="w-20 inline-flex items-center justify-center rounded-lg bg-yellow-500 hover:bg-yellow-600 px-3 py-2 text-[11px] font-bold text-black transition-all hover:scale-105 active:scale-95 shadow-lg shadow-yellow-500/20">
                                            Edit
                                        </a>

                                        <form action="{{ route('cash.destroy', $group->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus semua jadwal kas ini?')"
                                            style="display: contents">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-20 inline-flex items-center justify-center rounded-lg bg-rose-500 hover:bg-rose-600 px-3 py-2 text-[11px] font-bold text-white transition-all hover:scale-105 active:scale-95 shadow-lg shadow-rose-500/20">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t border-slate-700/50">
                                <td colspan="6" class="px-4 py-12 text-center text-slate-400 italic">
                                    Belum ada data jadwal kas untuk ditampilkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection