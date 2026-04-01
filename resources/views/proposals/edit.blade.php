@extends('layouts.app')

@section('content')

    <div class="max-w-3xl bg-white rounded-xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6">
            Edit Proposal
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('proposals.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')


            {{-- ORGANISASI PENGIRIM --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium">Organisasi Pengirim</label>

                @if($organizations->count() === 1)

                    <input type="hidden" name="organization_id" value="{{ $organizations->first()->id }}">

                    <input type="text" value="{{ $organizations->first()->name }}"
                        class="w-full border rounded px-3 py-2 bg-gray-100" readonly>

                @else

                    <select name="organization_id" class="w-full border rounded px-3 py-2">

                        @foreach($organizations as $org)

                            <option value="{{ $org->id }}" {{ old('organization_id', $proposal->organization_id) == $org->id ? 'selected' : '' }}>

                                {{ $org->name }}

                            </option>

                        @endforeach

                    </select>

                @endif

            </div>


            {{-- TUJUAN PROPOSAL --}}
            <div class="mb-4">

                <label class="block mb-1 font-medium">Kirim Proposal Ke</label>

                <select name="target_type" class="w-full border rounded px-3 py-2">

                    <option value="desa" {{ $proposal->target_type == 'desa' ? 'selected' : '' }}>
                        Kantor Desa
                    </option>

                    <option value="organization" {{ $proposal->target_type == 'organization' ? 'selected' : '' }}>
                        Organisasi Lain
                    </option>

                </select>

            </div>


            {{-- ORGANISASI TUJUAN --}}
            <div class="mb-4">

                <label class="block mb-1 font-medium">Pilih Organisasi Tujuan</label>

                <select name="target_organization_id" class="w-full border rounded px-3 py-2">

                    <option value="">-- Pilih Organisasi Tujuan --</option>

                    @foreach($organizations as $org)

                        <option value="{{ $org->id }}" {{ $proposal->target_organization_id == $org->id ? 'selected' : '' }}>

                            {{ $org->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- JUDUL --}}
            <div class="mb-4">

                <label class="block mb-1 font-medium">Judul Proposal</label>

                <input type="text" name="title" value="{{ old('title', $proposal->title) }}"
                    class="w-full border rounded px-3 py-2">

            </div>


            {{-- TANGGAL --}}
            <div class="mb-4">

                <label class="block mb-1 font-medium">Tanggal Proposal</label>

                <input type="date" name="proposal_date" value="{{ old('proposal_date', $proposal->proposal_date) }}"
                    class="w-full border rounded px-3 py-2">

            </div>


            {{-- DESKRIPSI --}}
            <div class="mb-4">

                <label class="block mb-1 font-medium">Deskripsi</label>

                <textarea name="description" rows="4"
                    class="w-full border rounded px-3 py-2">{{ old('description', $proposal->description) }}</textarea>

            </div>


            {{-- FILE LAMA --}}
            @if($proposal->file_path)

                <div class="mb-4">

                    <label class="block mb-1 font-medium">File Proposal Saat Ini</label>

                    <a href="{{ asset('storage/' . $proposal->file_path) }}" target="_blank" class="text-blue-600 underline">

                        Download Proposal

                    </a>

                </div>

            @endif


            {{-- FILE BARU --}}
            <div class="mb-4">

                <label class="block mb-1 font-medium">Upload File Baru (Opsional)</label>

                <input type="file" name="file" class="w-full border rounded px-3 py-2">

            </div>


            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

                Update Proposal

            </button>

        </form>

    </div>

@endsection