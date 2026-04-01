@extends('layouts.app')

@section('content')

    <div class="p-6 max-w-2xl">

        <h2 class="text-2xl font-bold mb-6 text-white">Edit Transaksi Keuangan</h2>

        <form action="{{ route('finance.update', $finance->id) }}" method="POST"
            class="space-y-4 bg-[#0b1220] border border-slate-700 rounded-xl shadow p-6">

            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-medium text-slate-300">Organisasi</label>

                <select name="organization_id"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">

                    @foreach($organizations as $org)

                        <option value="{{ $org->id }}" {{ $finance->organization_id == $org->id ? 'selected' : '' }}>
                            {{ $org->name }}
                        </option>

                    @endforeach

                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Tanggal</label>

                <input type="date" name="transaction_date" value="{{ $finance->transaction_date->format('Y-m-d') }}"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Jenis</label>

                <select name="type" class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">

                    <option value="income" {{ $finance->type == 'income' ? 'selected' : '' }}>
                        Pemasukan
                    </option>

                    <option value="expense" {{ $finance->type == 'expense' ? 'selected' : '' }}>
                        Pengeluaran
                    </option>

                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Kategori</label>

                <select name="category_id" class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">

                    <option value="">-- Pilih Kategori --</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $finance->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} ({{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }})
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Deskripsi</label>

                <textarea name="description"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">{{ $finance->description }}</textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Nominal</label>

                <input type="number" name="amount" value="{{ $finance->amount }}"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
            </div>

            <div class="flex gap-2 pt-2">

                <button class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-4 py-2 rounded">
                    Update
                </button>

                <a href="{{ route('finance.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded">
                    Kembali
                </a>

            </div>

        </form>

    </div>

@endsection