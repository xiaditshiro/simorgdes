@extends('layouts.app')

@section('content')

    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">Manajemen Proposal</h2>
                <p class="text-slate-400 mt-1">Kelola permohonan dan surat resmi antar organisasi.</p>
            </div>

            <!-- Tab Navigation - Responsive -->
            <div class="bg-slate-800/40 p-1.5 rounded-2xl border border-slate-700/50 flex flex-wrap gap-1">
                <a href="{{ route('proposals.inbox') }}" 
                   class="px-4 py-2 text-xs font-black uppercase tracking-widest transition-all rounded-xl {{ request()->routeIs('proposals.inbox') ? 'bg-cyan-500 text-black shadow-lg shadow-cyan-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
                   Masuk
                </a>
                <a href="{{ route('proposals.sent') }}" 
                   class="px-4 py-2 text-xs font-black uppercase tracking-widest transition-all rounded-xl {{ request()->routeIs('proposals.sent') ? 'bg-cyan-500 text-black shadow-lg shadow-cyan-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
                   Terkirim
                </a>
                <a href="{{ route('proposals.create') }}" 
                   class="px-4 py-2 text-xs font-black uppercase tracking-widest transition-all rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white hover:scale-105">
                   + Buat
                </a>
            </div>
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
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black">Organisasi</th>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black">Dikirim Ke</th>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black">Judul Proposal</th>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black">Tanggal</th>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black text-center">Status</th>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#0b1220] text-slate-200">
                        @forelse($proposals as $proposal)
                            <tr class="border-t border-slate-700/50 hover:bg-slate-800/30 transition">
                                <td class="px-4 py-4">
                                    <div class="text-slate-300 font-bold">{{ $proposal->organization?->name }}</div>
                                    <div class="text-[10px] text-slate-500">Pengirim</div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-slate-400 text-xs">
                                        @if($proposal->target_type === 'desa')
                                            <span class="text-amber-400 font-bold bg-amber-400/10 px-1.5 py-0.5 rounded border border-amber-400/20">PEMERINTAH DESA</span>
                                        @else
                                            {{ $proposal->targetOrganization?->name ?? '-' }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-white font-medium truncate max-w-[200px]">{{ $proposal->title }}</div>
                                </td>
                                <td class="px-4 py-4 text-slate-400 font-mono text-xs">
                                    {{ $proposal->proposal_date }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($proposal->status == 'pending')
                                        <span class="inline-block rounded-full bg-yellow-500/20 text-yellow-500 px-3 py-1 text-[10px] font-black border border-yellow-500/30 tracking-widest">
                                            MENUNGGU
                                        </span>
                                    @elseif($proposal->status == 'approved')
                                        <span class="inline-block rounded-full bg-emerald-500/20 text-emerald-400 px-3 py-1 text-[10px] font-black border border-emerald-500/30 tracking-widest">
                                            DISETUJUI
                                        </span>
                                    @else
                                        <span class="inline-block rounded-full bg-rose-500/20 text-rose-400 px-3 py-1 text-[10px] font-black border border-rose-500/30 tracking-widest">
                                            DITOLAK
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('proposals.show', $proposal->id) }}"
                                            class="inline-flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 px-3 py-2 text-[11px] font-bold text-white transition-all shadow-lg active:scale-95">
                                            Lihat
                                        </a>

                                        @if(auth()->user()->organization_id == $proposal->organization_id && $proposal->status == 'pending')
                                            <a href="{{ route('proposals.edit', $proposal->id) }}"
                                                class="inline-flex items-center justify-center rounded-lg bg-yellow-500 hover:bg-yellow-600 px-3 py-2 text-[11px] font-bold text-black transition-all shadow-lg active:scale-95">
                                                Edit
                                            </a>

                                            <form action="{{ route('proposals.destroy', $proposal->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus proposal ini?')"
                                                class="contents">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center rounded-lg bg-rose-500 hover:bg-rose-600 px-3 py-2 text-[11px] font-bold text-white transition-all shadow-lg active:scale-95">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-slate-400 italic">
                                    Data proposal masuk belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection