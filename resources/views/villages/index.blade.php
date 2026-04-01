@extends('layouts.app')

@section('content')

    <div class="space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">Data Desa</h2>
                <p class="text-slate-400 mt-1">Kelola data desa pada sistem.</p>
            </div>

            <a href="{{ route('villages.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                + Tambah Desa
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-emerald-400 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#111827] text-slate-300">
                        <tr>
                            <th class="px-4 py-4">No</th>
                            <th class="px-4 py-4">Nama Desa</th>
                            <th class="px-4 py-4">Kecamatan</th>
                            <th class="px-4 py-4">Kabupaten</th>
                            <th class="px-4 py-4">Provinsi</th>
                            <th class="px-4 py-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="bg-[#0b1220] text-slate-200">
                        @forelse($villages as $index => $village)
                            <tr class="border-t border-slate-700/50 hover:bg-slate-800/30 transition">
                                <td class="px-4 py-4">{{ $index + 1 }}</td>
                                <td class="px-4 py-4 font-medium text-white">{{ $village->name }}</td>
                                <td class="px-4 py-4">{{ $village->district }}</td>
                                <td class="px-4 py-4">{{ $village->regency }}</td>
                                <td class="px-4 py-4">{{ $village->province }}</td>

                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('villages.show', $village->id) }}"
                                            class="inline-flex items-center rounded-lg bg-slate-700 hover:bg-slate-600 px-3 py-2 text-xs font-medium text-white transition">
                                            Detail
                                        </a>

                                        <a href="{{ route('villages.edit', $village->id) }}"
                                            class="inline-flex items-center rounded-lg bg-yellow-500 hover:bg-yellow-600 px-3 py-2 text-xs font-medium text-white transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('villages.destroy', $village->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="inline-flex items-center rounded-lg bg-red-500 hover:bg-red-600 px-3 py-2 text-xs font-medium text-white transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t border-slate-700/50">
                                <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                    Belum ada data desa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection