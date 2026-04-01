@extends('layouts.app')

@section('content')

    <div class="max-w-3xl bg-[#0b1220] border border-slate-700 rounded-xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6 text-white">Buat Proposal Organisasi</h2>

        @if ($errors->any())
            <div class="bg-red-500/20 text-red-400 border border-red-500/30 p-3 mb-4 rounded">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('proposals.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium text-slate-300">Organisasi Pengirim</label>

                @if($senderOrganizations->count() === 1)
                    <input type="hidden" name="organization_id" value="{{ $senderOrganizations->first()->id }}">

                    <input type="text" value="{{ $senderOrganizations->first()->name }}"
                        class="w-full border border-slate-700 bg-slate-800 text-slate-300 rounded px-3 py-2" readonly>
                @else
                    <select name="organization_id"
                        class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
                        <option value="">-- Pilih Organisasi --</option>
                        @foreach($senderOrganizations as $org)
                            <option value="{{ $org->id }}">
                                {{ $org->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-slate-300">Kirim Proposal Ke</label>

                <select name="target_type" class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
                    <option value="desa">Kantor Desa</option>
                    <option value="organization">Organisasi Lain</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-slate-300">Pilih Organisasi Tujuan</label>

                <select name="target_organization_id"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
                    <option value="">-- Pilih Organisasi Tujuan --</option>

                    @foreach($targetOrganizations as $org)
                        <option value="{{ $org->id }}">
                            {{ $org->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-slate-300">Judul Proposal</label>

                <input type="text" name="title"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-slate-300">Tanggal Proposal</label>

                <input type="date" name="proposal_date" value="{{ old('proposal_date') }}"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-slate-300">Deskripsi</label>

                <textarea name="description" rows="4"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2"></textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium text-slate-300">Upload Proposal</label>

                <input type="file" name="file"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2 file:bg-slate-700 file:text-white file:border-0 file:px-3 file:py-2 file:mr-3">
            </div>

            <div class="flex gap-2">
                <button class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-4 py-2 rounded">
                    Simpan Proposal
                </button>

                <a href="{{ route('proposals.index') }}"
                    class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded">
                    Kembali
                </a>
            </div>

        </form>

    </div>

@endsection