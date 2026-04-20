@extends('layouts.app')

@section('content')

    <div class="space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">Kegiatan Organisasi</h2>
                <p class="text-slate-400 mt-1">Kelola data kegiatan organisasi pada sistem.</p>
            </div>

            <a href="{{ route('activities.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                Tambah Kegiatan
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-emerald-400 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-5 md:p-6">
            <form method="GET" action="{{ route('activities.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Organisasi</label>
                    <select name="organization_id"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                        <option value="">-- Semua Organisasi --</option>
                        @foreach($organizations as $organization)
                            <option value="{{ $organization->id }}" {{ request('organization_id') == $organization->id ? 'selected' : '' }}>
                                {{ $organization->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Status</label>
                    <select name="status"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                        <option value="">-- Semua Status --</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Kata Kunci</label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari judul kegiatan..."
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div class="xl:col-span-5 flex flex-wrap gap-3 pt-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                        Filter
                    </button>

                    <a href="{{ route('activities.index') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-slate-700 hover:bg-slate-600 px-5 py-3 text-sm font-medium text-white transition">
                        Reset
                    </a>

                    <a href="{{ route('activities.export.pdf', request()->query()) }}"
                        class="inline-flex items-center justify-center rounded-xl bg-red-600 hover:bg-red-700 px-5 py-3 text-sm font-medium text-white transition">
                        Export PDF
                    </a>

                    <a href="{{ route('activities.export.excel', request()->query()) }}"
                        class="inline-flex items-center justify-center rounded-xl bg-emerald-600 hover:bg-emerald-700 px-5 py-3 text-sm font-medium text-white transition">
                        Export Excel
                    </a>
                </div>
            </form>
        </div>

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#111827] text-slate-300">
                        <tr>
                            <th class="px-4 py-4">No</th>
                            <th class="px-4 py-4">Organisasi</th>
                            <th class="px-4 py-4">Judul</th>
                            <th class="px-4 py-4">Tanggal</th>
                            <th class="px-4 py-4">Status</th>
                            <th class="px-4 py-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="bg-[#0b1220] text-slate-200">
                        @forelse($activities as $activity)
                            <tr class="border-t border-slate-700/50 hover:bg-slate-800/30 transition">
                                <td class="px-4 py-4">{{ $loop->iteration }}</td>

                                <td class="px-4 py-4">
                                    {{ $activity->organization?->name }}
                                </td>

                                <td class="px-4 py-4 font-medium text-white">
                                    {{ $activity->title }}
                                </td>

                                <td class="px-4 py-4">
                                    {{ $activity->activity_date->format('d/m/Y H:i') }}
                                </td>


                                <td class="px-4 py-4">
                                    @if($activity->status === 'completed')
                                        <span class="inline-block rounded-full bg-emerald-500/20 text-emerald-400 px-3 py-1 text-xs font-semibold border border-emerald-500/30">
                                            Completed
                                        </span>
                                    @elseif($activity->status === 'scheduled')
                                        <span class="inline-block rounded-full bg-blue-500/20 text-blue-400 px-3 py-1 text-xs font-semibold border border-blue-500/30">
                                            Scheduled
                                        </span>
                                    @elseif($activity->status === 'draft')
                                        <span class="inline-block rounded-full bg-yellow-500/20 text-yellow-400 px-3 py-1 text-xs font-semibold border border-yellow-500/30">
                                            Draft
                                        </span>
                                    @elseif($activity->status === 'cancelled')
                                        <span class="inline-block rounded-full bg-rose-500/20 text-rose-400 px-3 py-1 text-xs font-semibold border border-rose-500/30">
                                            Cancelled
                                        </span>
                                    @else
                                        <span class="inline-block rounded-full bg-slate-500/20 text-slate-300 px-3 py-1 text-xs font-semibold border border-slate-500/30">
                                            {{ $activity->status }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('activities.attendances.index', $activity->id) }}"
                                            class="w-20 inline-flex items-center justify-center rounded-lg bg-emerald-600 hover:bg-emerald-700 px-3 py-2 text-[11px] font-bold text-white transition-all hover:scale-105 active:scale-95 shadow-lg shadow-emerald-500/20">
                                            Absensi
                                        </a>

                                        <a href="{{ route('activities.show', $activity->id) }}"
                                            class="w-20 inline-flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 px-3 py-2 text-[11px] font-bold text-white transition-all hover:scale-105 active:scale-95 border border-slate-600">
                                            Detail
                                        </a>

                                        <a href="{{ route('activities.edit', $activity->id) }}"
                                            class="w-20 inline-flex items-center justify-center rounded-lg bg-yellow-500 hover:bg-yellow-600 px-3 py-2 text-[11px] font-bold text-black transition-all hover:scale-105 active:scale-95 shadow-lg shadow-yellow-500/20">
                                            Edit
                                        </a>

                                        <form action="{{ route('activities.destroy', $activity->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')"
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
                                <td colspan="6" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center text-slate-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <p class="text-slate-400 font-medium">Belum ada data kegiatan untuk ditampilkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($activities->hasPages())
                <div class="px-4 py-4 border-t border-slate-700/50 bg-[#070b14]/50">
                    {{ $activities->links() }}
                </div>
            @endif
        </div>

    </div>

@endsection
ction