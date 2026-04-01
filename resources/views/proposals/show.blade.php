@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto bg-[#0b1220] border border-slate-700 rounded-xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6 text-white">
            Detail Proposal
        </h2>

        {{-- INFORMASI PROPOSAL --}}
        <div class="mb-6">

            <h3 class="text-lg font-semibold mb-3 text-white">Informasi Proposal</h3>

            <table class="w-full text-slate-300">

                <tr class="border-b border-slate-700">
                    <td class="py-2 font-medium w-40 text-slate-400">Judul</td>
                    <td>{{ $proposal->title }}</td>
                </tr>

                <tr class="border-b border-slate-700">
                    <td class="py-2 font-medium text-slate-400">Organisasi Pengirim</td>
                    <td>{{ $proposal->organization?->name }}</td>
                </tr>

                <tr class="border-b border-slate-700">
                    <td class="py-2 font-medium text-slate-400">Dikirim Ke</td>
                    <td>
                        @if($proposal->target_type === 'desa')
                            Kantor Desa
                        @else
                            {{ $proposal->targetOrganization?->name }}
                        @endif
                    </td>
                </tr>

                <tr class="border-b border-slate-700">
                    <td class="py-2 font-medium text-slate-400">Tanggal Proposal</td>
                    <td>{{ $proposal->proposal_date }}</td>
                </tr>

                <tr>
                    <td class="py-2 font-medium text-slate-400">Status</td>
                    <td>

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
                </tr>

            </table>

        </div>

        {{-- DESKRIPSI PROPOSAL --}}
        <div class="mb-6">

            <h3 class="text-lg font-semibold mb-3 text-white">Deskripsi Proposal</h3>

            <div class="border border-slate-700 rounded p-4 bg-[#111827] text-slate-300">
                {{ $proposal->description ?? 'Tidak ada deskripsi.' }}
            </div>

        </div>

        {{-- FILE PROPOSAL --}}
        <div class="mb-6">

            <h3 class="text-lg font-semibold mb-3 text-white">File Proposal</h3>

            @if($proposal->file_path)

                <a href="{{ asset('storage/' . $proposal->file_path) }}" target="_blank"
                    class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-4 py-2 rounded">

                    Download Proposal

                </a>

            @else

                <p class="text-slate-400">Tidak ada file proposal.</p>

            @endif

        </div>

        {{-- AKSI --}}
        @if($proposal->status == 'pending')

            <div class="border-t border-slate-700 pt-6">

                <h3 class="text-lg font-semibold mb-4 text-white">Tindakan</h3>

                <div class="flex gap-3">

                    <form action="{{ route('proposals.approve', $proposal->id) }}" method="POST">

                        @csrf

                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Terima Proposal
                        </button>

                    </form>

                    <form action="{{ route('proposals.reject', $proposal->id) }}" method="POST">

                        @csrf

                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                            Tolak Proposal
                        </button>

                    </form>

                </div>

            </div>

        @endif

        <hr class="my-6 border-slate-700">

        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-4 text-white">Diskusi Proposal</h3>

            <div class="border border-slate-700 rounded-xl bg-[#111827] p-4 h-[420px] overflow-y-auto space-y-3">
                @forelse($proposal->messages->sortBy('created_at') as $message)
                    @php
                        $isMine = auth()->id() === $message->user_id;
                    @endphp

                    <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%]">
                            <div
                                class="rounded-2xl px-4 py-3 shadow-sm
                                        {{ $isMine ? 'bg-cyan-600 text-white rounded-br-md' : 'bg-slate-700 text-slate-100 rounded-bl-md' }}">

                                <div class="text-xs font-semibold mb-1 {{ $isMine ? 'text-cyan-100' : 'text-cyan-300' }}">
                                    {{ $message->user?->name ?? 'User' }}
                                </div>

                                <div class="text-sm whitespace-pre-line">
                                    {{ $message->message }}
                                </div>

                                <div class="text-[11px] text-slate-300 text-right mt-2">
                                    {{ $message->created_at->format('d-m-Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-slate-400 py-10">
                        Belum ada diskusi.
                    </div>
                @endforelse
            </div>

            <form action="{{ route('proposals.messages.store', $proposal->id) }}" method="POST" class="mt-4">
                @csrf

                <div class="flex gap-3 items-end">
                    <div class="flex-1">
                        <textarea name="message" rows="2"
                            class="w-full border border-slate-700 bg-[#111827] text-white rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 resize-none"
                            placeholder="Tulis pesan..." required></textarea>
                    </div>

                    <button type="submit"
                        class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-5 py-3 rounded-2xl">
                        Kirim
                    </button>
                </div>
            </form>
        </div>

    </div>

@endsection