@extends('layouts.app')

@section('content')
    <div class="max-w-3xl bg-[#0b1220] border border-slate-700 rounded-xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6 text-white">Buat Jadwal Kas</h2>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-500/20 text-red-400 px-4 py-3 border border-red-500/30">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cash.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium text-slate-300">Organisasi</label>
                <select name="organization_id"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
                    <option value="">-- Pilih Organisasi --</option>
                    @foreach($organizations as $organization)
                        <option value="{{ $organization->id }}">
                            {{ $organization->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Judul Kas</label>
                <input type="text" name="title"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Jumlah Kas</label>
                <input type="number" name="amount"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-2 font-medium text-slate-300">Tanggal Pembayaran</label>

                <div id="date-wrapper" class="space-y-2">

                    <div class="flex gap-2">
                        <input type="date" name="dates[]"
                            class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">

                        <button type="button" onclick="removeDate(this)"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">
                            Hapus
                        </button>
                    </div>

                </div>

                <button type="button" onclick="addDate()"
                    class="mt-2 bg-slate-600 hover:bg-slate-500 text-white px-3 py-1 rounded text-sm">
                    + Tambah Tanggal
                </button>

            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Keterangan</label>
                <textarea name="description"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2"></textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-4 py-2 rounded">
                    Simpan Jadwal
                </button>

                <a href="{{ route('cash.index') }}" class="bg-slate-600 hover:bg-slate-500 text-white px-4 py-2 rounded">
                    Batal
                </a>
            </div>

        </form>
    </div>
@endsection


<script>

    function addDate() {

        let wrapper = document.getElementById('date-wrapper');

        let row = document.createElement('div');
        row.className = "flex gap-2";

        row.innerHTML = `
        <input type="date" name="dates[]" class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
        <button type="button"
            onclick="removeDate(this)"
            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">
            Hapus
        </button>
    `;

        wrapper.appendChild(row);

    }

    function removeDate(button) {

        button.parentElement.remove();

    }

</script>