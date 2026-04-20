@extends('layouts.app')

@section('content')

    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">Manajemen Keuangan</h2>
                <p class="text-slate-400 mt-1">Pantau dan kelola arus kas organisasi secara transparan.</p>
            </div>

            <a href="{{ route('finance.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                + Tambah Transaksi
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-emerald-400 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-rose-400 shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Ringkasan Keuangan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-[#0b1220]/90 border border-slate-700/60 p-5 rounded-2xl shadow-xl backdrop-blur-sm group hover:border-emerald-500/30 transition-all">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest italic">Total Pemasukan</p>
                    <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-emerald-400 tracking-tight">
                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </h3>
            </div>

            <div class="bg-[#0b1220]/90 border border-slate-700/60 p-5 rounded-2xl shadow-xl backdrop-blur-sm group hover:border-rose-500/30 transition-all">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest italic">Total Pengeluaran</p>
                    <div class="p-2 bg-rose-500/10 rounded-lg text-rose-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" /></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-rose-400 tracking-tight">
                    Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </h3>
            </div>

            <div class="bg-[#0b1220]/90 border border-slate-700/60 p-5 rounded-2xl shadow-xl backdrop-blur-sm group hover:border-cyan-500/30 transition-all">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest italic">Saldo Kas Sekarang</p>
                    <div class="p-2 bg-cyan-500/10 rounded-lg text-cyan-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-cyan-400 tracking-tight">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </h3>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg overflow-hidden backdrop-blur-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#111827] text-slate-300">
                        <tr>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black">Tanggal</th>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black">Organisasi</th>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black">Jenis</th>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black">Kategori</th>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black">Deskripsi</th>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black">Nominal</th>
                            <th class="px-4 py-4 uppercase tracking-widest text-[10px] font-black text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#0b1220] text-slate-200">
                        @forelse($transactions as $trx)
                            <tr class="border-t border-slate-700/50 hover:bg-slate-800/30 transition">
                                <td class="px-4 py-4 text-slate-400 font-mono text-xs whitespace-nowrap">
                                    {{ $trx->transaction_date->format('d-m-Y H:i') }}
                                </td>
                                <td class="px-4 py-4 text-slate-300 font-medium">
                                    {{ $trx->organization?->name }}
                                </td>
                                <td class="px-4 py-4">
                                    @if($trx->type === 'income')
                                        <span class="inline-block rounded-full bg-emerald-500/20 text-emerald-400 px-3 py-1 text-[10px] font-black border border-emerald-500/30 uppercase tracking-widest">
                                            PEMASUKAN
                                        </span>
                                    @else
                                        <span class="inline-block rounded-full bg-rose-500/20 text-rose-400 px-3 py-1 text-[10px] font-black border border-rose-500/30 uppercase tracking-widest">
                                            PENGELUARAN
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-xs text-cyan-400 font-bold bg-cyan-400/10 px-2 py-1 rounded-md border border-cyan-400/20">
                                        @if($trx->cash_payment_id && $trx->cashPayment?->member)
                                            {{ $trx->cashPayment->member->full_name }}
                                        @else
                                            {{ $trx->category }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-slate-400 text-xs max-w-[200px] truncate">
                                    {{ $trx->description }}
                                </td>
                                <td class="px-4 py-4 font-mono font-bold whitespace-nowrap {{ $trx->type === 'income' ? 'text-emerald-400' : 'text-rose-400' }}">
                                    {{ $trx->type === 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('finance.edit', $trx->id) }}"
                                            class="w-20 inline-flex items-center justify-center rounded-lg bg-yellow-500 hover:bg-yellow-600 px-3 py-2 text-[11px] font-bold text-black transition-all hover:scale-105 active:scale-95 shadow-lg shadow-yellow-500/20">
                                            Edit
                                        </a>

                                        <form action="{{ route('finance.destroy', $trx->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
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
                                <td colspan="7" class="px-4 py-12 text-center text-slate-400 italic">
                                    Belum ada data transaksi keuangan yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection