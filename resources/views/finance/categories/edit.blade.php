@extends('layouts.app')

@section('content')

    <div class="p-6 max-w-2xl">

        <h2 class="text-2xl font-bold mb-6">Edit Transaksi Keuangan</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('finance.update', $finance->id) }}" method="POST" class="space-y-4">

            @csrf
            @method('PUT')


            <div>
                <label class="block mb-1 font-medium">Organisasi</label>

                <select name="organization_id" class="w-full border rounded px-3 py-2">

                    @foreach($organizations as $org)

                        <option value="{{ $org->id }}" {{ $finance->organization_id == $org->id ? 'selected' : '' }}>

                            {{ $org->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            <div>
                <label class="block mb-1 font-medium">Tanggal Transaksi</label>

                <input type="date" name="transaction_date" class="w-full border rounded px-3 py-2"
                    value="{{ $finance->transaction_date->format('Y-m-d') }}">
            </div>


            <div>
                <label class="block mb-1 font-medium">Jenis Transaksi</label>

                <select name="type" class="w-full border rounded px-3 py-2">

                    <option value="income" {{ $finance->type == 'income' ? 'selected' : '' }}>
                        Pemasukan
                    </option>

                    <option value="expense" {{ $finance->type == 'expense' ? 'selected' : '' }}>
                        Pengeluaran
                    </option>

                </select>

            </div>


            <div>
                <label class="block mb-1 font-medium">Kategori</label>

                <select name="category" class="w-full border rounded px-3 py-2">

                    <option value="">-- Pilih Kategori --</option>

                    @foreach($categories as $category)

                        <option value="{{ $category->name }}" {{ $finance->category == $category->name ? 'selected' : '' }}>

                            {{ $category->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            <div>
                <label class="block mb-1 font-medium">Deskripsi</label>

                <textarea name="description" class="w-full border rounded px-3 py-2">{{ $finance->description }}</textarea>

            </div>


            <div>
                <label class="block mb-1 font-medium">Nominal</label>

                <input type="number" name="amount" class="w-full border rounded px-3 py-2" value="{{ $finance->amount }}">
            </div>


            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Update Transaksi
            </button>

        </form>

    </div>

@endsection