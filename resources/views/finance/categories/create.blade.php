@extends('layouts.app')

@section('content')

    <div class="p-6 max-w-2xl">

        <h2 class="text-2xl font-bold mb-6">Tambah Transaksi Keuangan</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('finance.store') }}" method="POST" class="space-y-4">

            @csrf

            <div>
                <label class="block mb-1 font-medium">Organisasi</label>

                <select name="organization_id" class="w-full border rounded px-3 py-2">

                    @foreach($organizations as $org)
                        <option value="{{ $org->id }}">
                            {{ $org->name }}
                        </option>
                    @endforeach

                </select>
            </div>


            <div>
                <label class="block mb-1 font-medium">Tanggal Transaksi</label>

                <input type="date" name="transaction_date" class="w-full border rounded px-3 py-2"
                    value="{{ old('transaction_date') }}">
            </div>


            <div>
                <label class="block mb-1 font-medium">Jenis Transaksi</label>

                <select name="type" class="w-full border rounded px-3 py-2">

                    <option value="income">Pemasukan</option>
                    <option value="expense">Pengeluaran</option>

                </select>
            </div>


            <div>
                <label class="block mb-1 font-medium">Kategori</label>

                <select name="category" class="w-full border rounded px-3 py-2">

                    <option value="">-- Pilih Kategori --</option>

                    @foreach($categories as $category)

                        <option value="{{ $category->name }}">
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div>
                <label class="block mb-1 font-medium">Deskripsi</label>

                <textarea name="description" class="w-full border rounded px-3 py-2"
                    placeholder="Contoh: beli snack rapat">{{ old('description') }}</textarea>

            </div>


            <div>
                <label class="block mb-1 font-medium">Nominal</label>

                <input type="number" name="amount" class="w-full border rounded px-3 py-2" placeholder="Contoh: 50000"
                    value="{{ old('amount') }}">
            </div>


            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Simpan Transaksi
            </button>

        </form>

    </div>

@endsection