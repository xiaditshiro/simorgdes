@extends('layouts.app')

@section('content')

    <main class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Data Anggota</h2>
                <p class="text-slate-400">Kelola data anggota organisasi.</p>
            </div>

            <a href="{{ route('members.create') }}"
                class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-4 py-2 rounded-lg shadow">
                + Tambah Anggota
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded bg-green-500/20 text-green-400 px-4 py-3 border border-green-500/30">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded bg-red-500/20 text-red-400 px-4 py-3 border border-red-500/30">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-[#0b1220] border border-slate-700 rounded-xl shadow overflow-hidden">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-[#111827] text-slate-300">
                    <tr>
                        <th class="text-left px-4 py-3">No</th>
                        <th class="text-left px-4 py-3">Nama</th>
                        <th class="text-left px-4 py-3">Organisasi</th>
                        <th class="text-left px-4 py-3">Jabatan</th>
                        <th class="text-left px-4 py-3">No HP</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-200">
                    @forelse($members as $index => $member)
                        <tr class="border-t border-slate-700 hover:bg-slate-800/40">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-white">{{ $member->full_name }}</td>
                            <td class="px-4 py-3">{{ $member->organization?->name }}</td>
                            <td class="px-4 py-3">{{ ucfirst($member->position) }}</td>
                            <td class="px-4 py-3">{{ $member->phone }}</td>

                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded bg-cyan-500/20 text-cyan-400">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 flex gap-2 flex-wrap">

                                <a href="{{ route('members.show', $member->id) }}"
                                    class="bg-slate-600 hover:bg-slate-500 text-white px-3 py-1 rounded text-xs">
                                    Detail
                                </a>

                                <a href="{{ route('members.edit', $member->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                    Edit
                                </a>

                                <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                        Hapus
                                    </button>
                                </form>

                                @if(!$member->user_id)
                                    <form action="{{ route('members.create-user', $member->id) }}" method="POST"
                                        onsubmit="return confirm('Buat akun login untuk anggota ini?')">
                                        @csrf
                                        <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                            Buat Akun
                                        </button>
                                    </form>
                                @else
                                    <span class="bg-green-500 text-white px-3 py-1 rounded text-xs">
                                        Sudah Punya Akun
                                    </span>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr class="border-t border-slate-700">
                            <td colspan="7" class="px-4 py-6 text-center text-slate-400">
                                Belum ada data anggota.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

@endsection