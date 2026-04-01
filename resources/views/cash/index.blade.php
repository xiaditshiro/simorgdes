@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Jadwal Kas</h2>
                <p class="text-slate-400">Kelola jadwal pembayaran kas organisasi.</p>
            </div>

            <a href="{{ route('cash.create') }}"
                class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-4 py-2 rounded-lg shadow">
                + Buat Jadwal Kas
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded bg-green-500/20 text-green-400 px-4 py-3 border border-green-500/30">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#0b1220] border border-slate-700 rounded-xl shadow overflow-hidden">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-[#111827] text-slate-300">
                    <tr>
                        <th class="text-left px-4 py-3">No</th>
                        <th class="text-left px-4 py-3">Organisasi</th>
                        <th class="text-left px-4 py-3">Judul Kas</th>
                        <th class="text-left px-4 py-3">Jumlah</th>
                        <th class="text-left px-4 py-3">Total Jadwal</th>
                        <th class="text-left px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-200">
                    @forelse($groups as $group)
                        <tr class="border-t border-slate-700 hover:bg-slate-800/40">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $group->organization?->name }}</td>
                            <td class="px-4 py-3 font-medium text-white">{{ $group->title }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($group->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded bg-cyan-500/20 text-cyan-400">
                                    {{ $group->schedules->count() }} tanggal
                                </span>
                            </td>
                            <td class="px-4 py-3 flex gap-2">
                                <a href="{{ route('cash.show', $group->id) }}"
                                    class="bg-slate-600 hover:bg-slate-500 text-white px-3 py-1 rounded text-sm">
                                    Detail
                                </a>

                                <a href="{{ route('cash.edit', $group->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('cash.destroy', $group->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus semua jadwal kas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t border-slate-700">
                            <td colspan="6" class="px-4 py-6 text-center text-slate-400">
                                Belum ada jadwal kas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection