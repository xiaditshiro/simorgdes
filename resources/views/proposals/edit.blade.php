@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-wide text-white">Edit Proposal</h2>
                <p class="text-slate-400 mt-1">Perbarui informasi dan dokumen proposal yang telah diajukan.</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-700/60 bg-[#0b1220]/90 shadow-2xl p-6 sm:p-10 backdrop-blur-sm">

            @if ($errors->any())
                <div class="mb-8 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 px-5 py-4 shadow-lg">
                    <p class="font-black uppercase tracking-widest text-xs mb-2 italic">Perhatian:</p>
                    <ul class="list-disc ml-5 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('proposals.update', $proposal->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- ORGANISASI PENGIRIM --}}
                    <div>
                        <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Organisasi Pengirim</label>

                        @if($senderOrganizations->count() === 1)
                            <input type="hidden" name="organization_id" value="{{ $senderOrganizations->first()->id }}">
                            <div class="w-full rounded-2xl border border-slate-700/50 bg-slate-800/30 px-5 py-4 text-slate-400 font-bold flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                {{ $senderOrganizations->first()->name }}
                            </div>
                        @else
                            <select name="organization_id" class="w-full rounded-2xl border border-slate-700 bg-[#111827] px-5 py-4 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition-all font-bold">
                                @foreach($senderOrganizations as $org)
                                    <option value="{{ $org->id }}" {{ old('organization_id', $proposal->organization_id) == $org->id ? 'selected' : '' }}>
                                        {{ $org->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    {{-- JUDUL --}}
                    <div>
                        <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Judul Proposal</label>
                        <input type="text" name="title" value="{{ old('title', $proposal->title) }}" placeholder="Ketik judul proposal..."
                            class="w-full rounded-2xl border border-slate-700 bg-[#111827] px-5 py-4 text-white placeholder-slate-600 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition-all font-bold">
                    </div>

                    {{-- TUJUAN PROPOSAL --}}
                    <div>
                        <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Destinasi Surat</label>
                        <select id="target_type" name="target_type" class="w-full rounded-2xl border border-slate-700 bg-[#111827] px-5 py-4 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition-all font-bold">
                            <option value="desa" {{ old('target_type', $proposal->target_type) == 'desa' ? 'selected' : '' }}>
                                Kantor Desa
                            </option>
                            <option value="organization" {{ old('target_type', $proposal->target_type) == 'organization' ? 'selected' : '' }}>
                                Organisasi Lain
                            </option>
                        </select>
                    </div>

                    {{-- ORGANISASI TUJUAN --}}
                    <div id="target_org_container">
                        <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Organisasi Tujuan</label>
                        <select id="target_organization_id" name="target_organization_id" class="w-full rounded-2xl border border-slate-700 bg-[#111827] px-5 py-4 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition-all font-bold disabled:opacity-30 disabled:cursor-not-allowed">
                            <option value="">-- Pilih Organisasi --</option>
                            @foreach($targetOrganizations as $org)
                                <option value="{{ $org->id }}" {{ old('target_organization_id', $proposal->target_organization_id) == $org->id ? 'selected' : '' }}>
                                    {{ $org->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TANGGAL --}}
                    <div>
                        <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Tanggal Berkas</label>
                        <input type="date" name="proposal_date" value="{{ old('proposal_date', $proposal->proposal_date) }}"
                            class="w-full rounded-2xl border border-slate-700 bg-[#111827] px-5 py-4 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition-all font-mono font-bold">
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div>
                    <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Ringkasan Konteks</label>
                    <textarea name="description" rows="5" placeholder="Tuliskan poin-poin penting isi proposal..."
                        class="w-full rounded-2xl border border-slate-700 bg-[#111827] px-5 py-4 text-white placeholder-slate-600 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition-all resize-none leading-relaxed">{{ old('description', $proposal->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t border-slate-700/50">
                    
                    {{-- FILE BARU --}}
                    <div class="space-y-3">
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-500 italic">Ganti Dokumen (PDF)</label>
                        <div class="relative">
                            <input type="file" name="file" accept="application/pdf"
                                class="w-full rounded-2xl border border-dashed border-slate-600 bg-black/20 p-6 text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:bg-cyan-500 file:text-black hover:file:bg-cyan-400 cursor-pointer">
                        </div>
                        <p class="text-[10px] text-slate-500">* Mengunggah file baru akan menghapus berkas sebelumnya secara permanen.</p>
                    </div>

                    {{-- FILE LAMA --}}
                    <div class="space-y-3">
                         <label class="block text-xs font-black uppercase tracking-widest text-slate-500 italic">Berkas Saat Ini</label>
                         @if($proposal->file_path)
                            <div class="p-6 rounded-2xl bg-cyan-500/5 border border-cyan-500/20 flex flex-col items-center justify-center gap-4 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-cyan-400 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <a href="{{ asset('storage/' . $proposal->file_path) }}" target="_blank" 
                                    class="text-xs font-black uppercase tracking-widest text-cyan-400 hover:text-cyan-300 underline decoration-cyan-500/30 underline-offset-4 transition">
                                    Lihat Lampiran Aktif
                                </a>
                            </div>
                         @else
                            <div class="p-6 rounded-2xl bg-slate-800/30 border border-slate-700/50 flex items-center justify-center text-slate-600 italic text-sm">
                                Tidak ada dokumen terlampir
                            </div>
                         @endif
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-4 pt-8 border-t border-slate-700/50">
                    <button type="submit"
                        class="rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-10 py-4 text-sm font-black uppercase tracking-widest text-white shadow-xl shadow-cyan-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('proposals.index') }}"
                        class="rounded-2xl bg-slate-800 border border-slate-700 px-10 py-4 text-sm font-black uppercase tracking-widest text-slate-400 hover:bg-slate-700 hover:text-white transition-all">
                        Batal
                    </a>
                </div>

            </form>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const targetTypeSelect = document.getElementById('target_type');
            const targetOrgSelect = document.getElementById('target_organization_id');

            function toggleTargetOrg() {
                if (targetTypeSelect.value === 'desa') {
                    targetOrgSelect.disabled = true;
                    targetOrgSelect.closest('#target_org_container').classList.add('opacity-40');
                    targetOrgSelect.value = '';
                } else {
                    targetOrgSelect.disabled = false;
                    targetOrgSelect.closest('#target_org_container').classList.remove('opacity-40');
                }
            }

            targetTypeSelect.addEventListener('change', toggleTargetOrg);
            toggleTargetOrg();
        });
    </script>
@endsection