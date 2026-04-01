@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="text-3xl font-bold text-white">Kelola Kategori Keuangan</h2>
            <p class="text-slate-400">Atur kategori pemasukan dan pengeluaran untuk organisasi Anda.</p>
        </div>

        @if(session('success'))
            <div class="rounded-xl bg-emerald-500/10 text-emerald-400 p-4 border border-emerald-500/20 shadow-lg flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#0b1220] border border-slate-700/60 rounded-2xl shadow-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Tambah Kategori Baru</h3>
            <form action="{{ route('finance.categories.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <input type="text" name="name" placeholder="Nama kategori (e.g. Iuran Bulanan)" 
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                    </div>

                    <div>
                        <select name="type" class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2.5 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 transition">
                            <option value="income">Pemasukan</option>
                            <option value="expense">Pengeluaran</option>
                        </select>
                    </div>

                    <button class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-2.5 text-sm font-medium text-white shadow-[0_0_20px_rgba(59,130,246,0.25)] hover:scale-[1.02] active:scale-[0.98] transition">
                        + Tambah Kategori
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-[#0b1220] border border-slate-700 rounded-2xl shadow-xl overflow-hidden">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-[#111827] text-slate-300">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-4 text-center font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-slate-200 divide-y divide-slate-700/50">
                    @foreach($categories as $cat)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4 font-medium text-white">
                                {{ $cat->name }}
                            </td>

                            <td class="px-6 py-4">
                                @if($cat->type == 'income')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-500/10 text-cyan-400">
                                        Pemasukan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-500/10 text-amber-400">
                                        Pengeluaran
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('finance.categories.delete', $cat->id) }}" method="POST" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="inline-flex items-center text-rose-500 hover:text-rose-400 hover:bg-rose-500/10 px-3 py-1.5 rounded-lg transition-all">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection