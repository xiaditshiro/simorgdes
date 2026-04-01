@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="text-3xl font-bold text-white">Kas Saya</h2>
            <p class="text-slate-400">Lihat riwayat dan status pembayaran kas Anda.</p>
        </div>

        <div class="bg-[#0b1220] border border-slate-700 rounded-2xl shadow-xl overflow-hidden">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-[#111827] text-slate-300">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Kegiatan</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Tanggal Jatuh Tempo</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>

                <tbody class="text-slate-200 divide-y divide-slate-700/50">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $payment->schedule->title }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $payment->schedule->group->title ?? '' }}</div>
                            </td>

                            <td class="px-6 py-4 text-slate-400">
                                {{ \Carbon\Carbon::parse($payment->schedule->due_date)->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-cyan-400">
                                Rp {{ number_format($payment->schedule->amount, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($payment->status == 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5"></span>
                                        Sudah Bayar
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400 mr-1.5"></span>
                                        Belum Bayar
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-500">
                                    <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p>Tidak ada data pembayaran kas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection