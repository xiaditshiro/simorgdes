@extends('layouts.app')

@section('content')

    <div class="p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Proposal Masuk</h2>

            <a href="{{ route('proposals.create') }}"
                class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-4 py-2 rounded">
                Buat Proposal
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 text-green-400 border border-green-500/30 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#0b1220] border border-slate-700 rounded-xl shadow overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-[#111827] text-slate-300">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Organisasi</th>
                        <th class="p-3 text-left">Dikirim Ke</th>
                        <th class="p-3 text-left">Judul</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-slate-200">

                    @forelse($proposals as $proposal)

                        <tr class="border-t border-slate-700 hover:bg-slate-800/40">

                            <td class="p-3">{{ $loop->iteration }}</td>

                            <td class="p-3">
                                {{ $proposal->organization?->name }}
                            </td>

                            <td class="p-3">
                                @if($proposal->target_type === 'desa')
                                    Kantor Desa
                                @else
                                    {{ $proposal->targetOrganization?->name ?? '-' }}
                                @endif
                            </td>

                            <td class="p-3">
                                {{ $proposal->title }}
                            </td>

                            <td class="p-3">
                                {{ $proposal->proposal_date }}
                            </td>

                            <td class="p-3">

                                @if($proposal->status == 'pending')
                                    <span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded text-xs">
                                        Menunggu
                                    </span>
                                @endif

                                @if($proposal->status == 'approved')
                                    <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded text-xs">
                                        Disetujui
                                    </span>
                                @endif

                                @if($proposal->status == 'rejected')
                                    <span class="bg-red-500/20 text-red-400 px-2 py-1 rounded text-xs">
                                        Ditolak
                                    </span>
                                @endif

                            </td>

                            <td class="p-3 flex gap-2">

                                <a href="{{ route('proposals.show', $proposal->id) }}"
                                    class="bg-slate-600 hover:bg-slate-700 text-white px-3 py-1 rounded text-sm">
                                    Detail
                                </a>

                                @if(
                                        auth()->user()->organization_id == $proposal->organization_id &&
                                        $proposal->status == 'pending'
                                    )

                                    <a href="{{ route('proposals.edit', $proposal->id) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('proposals.destroy', $proposal->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus proposal ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="p-6 text-center text-slate-400">
                                Belum ada proposal.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection