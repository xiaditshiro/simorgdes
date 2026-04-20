@extends('layouts.app')

@section('content')

    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">Data Anggota</h2>
                <p class="text-slate-400 mt-1">Kelola data anggota organisasi pada sistem.</p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <a href="{{ route('members.create') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                    + Tambah Anggota
                </a>
            </div>
        </div>

        {{-- Filter & Search Form --}}
        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-5 md:p-6">
            <form action="{{ route('members.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                
                <div class="xl:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-slate-300">Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIK..." 
                           class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                @if(isset($organizations))
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Organisasi</label>
                    <select name="organization_id" class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                        <option value="">-- Semua Organisasi --</option>
                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}" {{ request('organization_id') == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Jabatan</label>
                    <select name="position" class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                        <option value="">-- Semua Jabatan --</option>
                        <option value="anggota" {{ request('position') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                        <option value="ketua" {{ request('position') == 'ketua' ? 'selected' : '' }}>Ketua</option>
                        <option value="sekretaris" {{ request('position') == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                        <option value="bendahara" {{ request('position') == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Status</label>
                    <select name="status" class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                        <option value="">-- Semua Status --</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="xl:col-span-5 flex flex-wrap gap-3 pt-2">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                        Filter
                    </button>
                    
                    <a href="{{ route('members.index') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-700 hover:bg-slate-600 px-5 py-3 text-sm font-medium text-white transition">
                        Reset
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['export' => 'csv']) }}"
                        class="inline-flex items-center justify-center rounded-xl bg-emerald-600 hover:bg-emerald-700 px-5 py-3 text-sm font-medium text-white transition">
                        Export CSV
                    </a>
                </div>
            </form>
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
                            <th class="px-4 py-4">Nama Anggota</th>
                            <th class="px-4 py-4">Organisasi</th>
                            <th class="px-4 py-4">No HP</th>
                            <th class="px-4 py-4">Status</th>
                            <th class="px-4 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#0b1220] text-slate-200">
                        @forelse($members as $index => $member)
                            <tr class="border-t border-slate-700/50 hover:bg-slate-800/30 transition">
                                <td class="px-4 py-4 text-slate-400 font-mono text-xs">
                                    {{ $members->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-white font-medium">{{ $member->full_name }}</span>
                                        <span class="text-[10px] text-cyan-400 uppercase tracking-tighter">{{ $member->position }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-300">
                                    {{ $member->organization?->name ?? '-' }}
                                </td>
                                <td class="px-4 py-4 text-slate-400">
                                    {{ $member->phone ?? '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    @if($member->status == 'aktif')
                                        <span class="inline-block rounded-full bg-emerald-500/20 text-emerald-400 px-3 py-1 text-xs font-semibold border border-emerald-500/30 uppercase tracking-wider">AKTIF</span>
                                    @else
                                        <span class="inline-block rounded-full bg-slate-500/20 text-slate-400 px-3 py-1 text-xs font-semibold border border-slate-500/30 uppercase tracking-wider">NONAKTIF</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('members.show', $member->id) }}"
                                            class="w-20 inline-flex items-center justify-center rounded-lg bg-slate-700 hover:bg-slate-600 px-3 py-2 text-[11px] font-bold text-white transition-all hover:scale-105 active:scale-95 border border-slate-600">
                                            Detail
                                        </a>

                                        <a href="{{ route('members.edit', $member->id) }}"
                                            class="w-20 inline-flex items-center justify-center rounded-lg bg-yellow-500 hover:bg-yellow-600 px-3 py-2 text-[11px] font-bold text-black transition-all hover:scale-105 active:scale-95 shadow-lg shadow-yellow-500/20">
                                            Edit
                                        </a>

                                        <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data anggota ini?')"
                                            style="display: contents">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-20 inline-flex items-center justify-center rounded-lg bg-rose-500 hover:bg-rose-600 px-3 py-2 text-[11px] font-bold text-white transition-all hover:scale-105 active:scale-95 shadow-lg shadow-rose-500/20">
                                                Hapus
                                            </button>
                                        </form>

                                        @if(!$member->user_id)
                                            <form action="{{ route('members.create-user', $member->id) }}" method="POST"
                                                onsubmit="return confirm('Buat akun login untuk anggota ini?')"
                                                style="display: contents">
                                                @csrf
                                                <button type="submit"
                                                    class="w-24 inline-flex items-center justify-center rounded-lg bg-cyan-600 hover:bg-cyan-500 px-3 py-2 text-[10px] font-black text-white transition-all hover:scale-105 active:scale-95 shadow-lg shadow-cyan-500/20 uppercase tracking-tighter">
                                                    Buat Akun
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-24 inline-flex items-center justify-center rounded-lg bg-emerald-600/10 border border-emerald-600/30 px-3 py-2 text-[10px] font-black text-emerald-400 uppercase tracking-tighter cursor-default">
                                                Terkoneksi
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t border-slate-700/50">
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center text-slate-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        </div>
                                        <p class="text-slate-400 font-medium">Belum ada data anggota untuk organisasi ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($members->hasPages())
                <div class="px-6 py-4 border-t border-slate-700/50 bg-slate-900/50">
                    {{ $members->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection