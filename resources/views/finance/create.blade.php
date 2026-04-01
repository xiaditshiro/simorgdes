@extends('layouts.app')

@section('content')

    <div class="p-6 max-w-2xl">

        <h2 class="text-2xl font-bold mb-6 text-white">Tambah Transaksi Keuangan</h2>

        @if($errors->any())
            <div class="bg-red-500/20 text-red-400 p-3 mb-4 rounded border border-red-500/30">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('finance.store') }}" method="POST"
            class="space-y-4 bg-[#0b1220] border border-slate-700 rounded-xl shadow p-6">

            @csrf

            <div>
                <label class="block mb-1 font-medium text-slate-300">Organisasi</label>

                <select name="organization_id"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">

                    @foreach($organizations as $org)
                        <option value="{{ $org->id }}">
                            {{ $org->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Tanggal</label>

                <input type="date" name="transaction_date"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Jenis</label>

                <select name="type" class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
                    <option value="income">Pemasukan</option>
                    <option value="expense">Pengeluaran</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Kategori</label>

                <select name="category_id" class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
                    <option value="">-- Pilih Kategori --</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }} ({{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Deskripsi</label>

                <textarea name="description"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2"></textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Nominal</label>

                <input type="number" name="amount"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
            </div>

            <div class="flex gap-2 pt-2">

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>

                <a href="{{ route('finance.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded">
                    Kembali
                </a>

            </div>

        </form>

    </div>

@endsection