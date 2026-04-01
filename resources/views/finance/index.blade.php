@extends('layouts.app')

@section('content')

    <div class="p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Manajemen Keuangan</h2>

            <a href="{{ route('finance.create') }}"
                class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-4 py-2 rounded">
                + Tambah Transaksi
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 text-green-400 p-3 mb-4 rounded border border-green-500/30">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/20 text-red-400 p-3 mb-4 rounded border border-red-500/30">
                {{ session('error') }}
            </div>
        @endif

        <!-- Ringkasan Keuangan -->

        <div class="grid grid-cols-3 gap-4 mb-6">

            <div class="bg-[#0b1220] border border-slate-700 p-4 rounded shadow">
                <p class="text-sm text-slate-400">Total Pemasukan</p>
                <h3 class="text-xl font-bold text-green-400">
                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </h3>
            </div>

            <div class="bg-[#0b1220] border border-slate-700 p-4 rounded shadow">
                <p class="text-sm text-slate-400">Total Pengeluaran</p>
                <h3 class="text-xl font-bold text-red-400">
                    Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </h3>
            </div>

            <div class="bg-[#0b1220] border border-slate-700 p-4 rounded shadow">
                <p class="text-sm text-slate-400">Saldo Kas</p>
                <h3 class="text-xl font-bold text-cyan-400">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </h3>
            </div>

        </div>

        <!-- Tabel Transaksi -->

        <div class="bg-[#0b1220] border border-slate-700 shadow rounded overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-[#111827] text-slate-300">
                    <tr>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Organisasi</th>
                        <th class="p-3 text-left">Jenis</th>
                        <th class="p-3 text-left">Kategori</th>
                        <th class="p-3 text-left">Deskripsi</th>
                        <th class="p-3 text-left">Nominal</th>
                        <th class="p-3 text-left">Sumber</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-slate-200">

                    @forelse($transactions as $trx)

                        <tr class="border-t border-slate-700 hover:bg-slate-800/40">

                            <td class="p-3">
                                {{ $trx->transaction_date->format('d-m-Y') }}
                            </td>

                            <td class="p-3">
                                {{ $trx->organization?->name }}
                            </td>

                            <td class="p-3">

                                @if($trx->type === 'income')
                                    <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded text-xs">
                                        Pemasukan
                                    </span>
                                @else
                                    <span class="bg-red-500/20 text-red-400 px-2 py-1 rounded text-xs">
                                        Pengeluaran
                                    </span>
                                @endif

                            </td>

                            <td class="p-3">
                                {{ $trx->category }}
                            </td>

                            <td class="p-3">
                                {{ $trx->description }}
                            </td>

                            <td class="p-3 font-semibold">
                                Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </td>

                            <td class="p-3">
                                @if($trx->source === 'cash_payment')
                                    <span class="bg-blue-500/20 text-blue-400 px-2 py-1 rounded text-xs">
                                        {{ $trx->cashPayment?->member?->full_name ?? 'Pembayar Kas' }}
                                    </span>
                                @else
                                    <span class="bg-slate-600 text-slate-200 px-2 py-1 rounded text-xs">
                                        {{ $trx->creator?->name ?? 'Manual' }}
                                    </span>
                                @endif
                            </td>

                            <td class="p-3 flex gap-2">

                                <a href="{{ route('finance.edit', $trx->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('finance.destroy', $trx->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="p-6 text-center text-slate-400">
                                Belum ada transaksi keuangan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection