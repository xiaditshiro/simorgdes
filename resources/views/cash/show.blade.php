@extends('layouts.app')

@section('content')
    <div class="bg-[#0b1220] border border-slate-700 rounded-xl shadow p-6 mb-6 flex justify-between items-start">

        <div>
            <h2 class="text-2xl font-bold mb-4 text-white">{{ $cash->title }}</h2>

            <p class="text-slate-300"><strong class="text-slate-400">Organisasi:</strong> {{ $cash->organization?->name }}
            </p>
            <p class="text-slate-300"><strong class="text-slate-400">Jumlah Kas:</strong> Rp
                {{ number_format($cash->amount, 0, ',', '.') }}
            </p>
            <p class="text-slate-300"><strong class="text-slate-400">Total Jadwal:</strong> {{ $cash->schedules->count() }}
                tanggal</p>
            <p class="text-slate-300"><strong class="text-slate-400">Keterangan:</strong> {{ $cash->description }}</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('cash.pdf', $cash->id) }}"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                Export PDF
            </a>

            <a href="{{ route('cash.excel', $cash->id) }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                Export Excel
            </a>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-[#0b1220] border border-slate-700 rounded-xl shadow p-4">
            <p class="text-sm text-slate-400">Total Anggota</p>
            <h3 class="text-2xl font-bold text-white">{{ $members->count() }}</h3>
        </div>

        <div class="bg-[#0b1220] border border-slate-700 rounded-xl shadow p-4">
            <p class="text-sm text-slate-400">Total Jadwal</p>
            <h3 class="text-2xl font-bold text-white">{{ $cash->schedules->count() }}</h3>
        </div>

        <div class="bg-[#0b1220] border border-slate-700 rounded-xl shadow p-4">
            <p class="text-sm text-slate-400">Total Pembayaran Lunas</p>
            <h3 class="text-2xl font-bold text-white">{{ $totalPaidCount }}</h3>
        </div>

        <div class="bg-[#0b1220] border border-slate-700 rounded-xl shadow p-4">
            <p class="text-sm text-slate-400">Total Kas Masuk</p>
            <h3 class="text-2xl font-bold text-white">Rp {{ number_format($totalCashIn, 0, ',', '.') }}</h3>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded bg-green-500/20 text-green-400 px-4 py-3 border border-green-500/30">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#0b1220] border border-slate-700 rounded-xl shadow overflow-auto">
        <table class="min-w-full border-collapse text-sm">
            <thead class="bg-[#111827] text-slate-300">
                <tr>
                    <th class="text-left px-4 py-3 border border-slate-700">Nama Anggota</th>

                    @foreach($cash->schedules as $schedule)
                        <th class="text-center px-4 py-3 border border-slate-700 whitespace-nowrap">
                            {{ $schedule->due_date->format('d-m-Y') }}
                        </th>
                    @endforeach

                    <th class="text-center px-4 py-3 border border-slate-700">Total Lunas</th>
                </tr>
            </thead>

            <tbody class="text-slate-200">
                @forelse($members as $member)
                    <tr class="border-t border-slate-700 hover:bg-slate-800/40">
                        <td class="px-4 py-3 border border-slate-700 font-medium whitespace-nowrap text-white">
                            {{ $member->full_name }}
                        </td>

                        @foreach($cash->schedules as $schedule)
                            @php
                                $payment = $paymentMap[$member->id][$schedule->id] ?? null;
                            @endphp

                            <td class="px-4 py-3 border border-slate-700 text-center">
                                @if($payment)
                                    @if($payment->status === 'paid')
                                        <form action="{{ route('cash.unpaid', $payment->id) }}" method="POST">
                                            @csrf
                                            <button class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                                                ✔
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('cash.paid', $payment->id) }}" method="POST">
                                            @csrf
                                            <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                                ✘
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        @endforeach

                        <td class="px-4 py-3 border border-slate-700 text-center font-bold text-white">
                            {{ $memberTotals[$member->id] ?? 0 }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 2 + $cash->schedules->count() }}"
                            class="px-4 py-6 text-center text-slate-400 border border-slate-700">
                            Belum ada anggota.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot class="bg-[#111827] text-slate-300">
                <tr>
                    <th class="text-left px-4 py-3 border border-slate-700">Total Bayar</th>

                    @foreach($cash->schedules as $schedule)
                        <th class="text-center px-4 py-3 border border-slate-700">
                            {{ $scheduleTotals[$schedule->id] ?? 0 }}
                        </th>
                    @endforeach

                    <th class="text-center px-4 py-3 border border-slate-700">
                        {{ $totalPaidCount }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('cash.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded text-sm">
            Kembali
        </a>
    </div>

@endsection