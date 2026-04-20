@extends('layouts.app')

@section('content')

    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-white tracking-wide">Edit Transaksi</h2>
                <p class="text-slate-400 mt-1">Perbarui rincian transaksi keuangan organisasi.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-4 py-4 text-rose-400 shadow-lg">
                <p class="font-semibold mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc ml-5 space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6">
            <form action="{{ route('finance.update', $finance->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Organisasi</label>
                    <select name="organization_id"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}" {{ old('organization_id', $finance->organization_id) == $org->id ? 'selected' : '' }}>
                                {{ $org->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm text-slate-400">Tanggal & Waktu Transaksi</label>
                        <input type="datetime-local" name="transaction_date" value="{{ old('transaction_date', $finance->transaction_date->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm text-slate-400">Jenis Transaksi</label>
                        <select id="type" name="type" class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                            <option value="income" {{ old('type', $finance->type) == 'income' ? 'selected' : '' }}>Pemasukan (+)</option>
                            <option value="expense" {{ old('type', $finance->type) == 'expense' ? 'selected' : '' }}>Pengeluaran (-)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Kategori</label>
                    <select id="category_id" name="category_id" class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-type="{{ $category->type }}" {{ (old('category_id') == $category->id || (!old('category_id') && $finance->category == $category->name)) ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Nominal (Rp)</label>
                    <input type="number" name="amount" value="{{ old('amount', $finance->amount) }}" placeholder="Contoh: 75000"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 font-mono">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Deskripsi / Catatan</label>
                    <textarea name="description" rows="3" placeholder="Rincian transaksi..."
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">{{ old('description', $finance->description) }}</textarea>
                </div>

                <div class="flex flex-wrap gap-3 pt-4">
                    <button type="submit"
                        class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-3 text-sm font-bold text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                        Perbarui Transaksi
                    </button>

                    <a href="{{ route('finance.index') }}"
                        class="rounded-xl bg-slate-800 border border-slate-700 px-8 py-3 text-sm font-bold text-slate-300 hover:bg-slate-700 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const typeSelect = document.getElementById('type');

            categorySelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const type = selectedOption.getAttribute('data-type');
                
                if (type) {
                    typeSelect.value = type;
                }
            });
        });
    </script>
@endsection