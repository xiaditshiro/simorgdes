@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-white tracking-wide">Buat Proposal</h2>
                <p class="text-slate-400 mt-1">Buat permohonan baru secara digital untuk organisasi lain.</p>
            </div>

            <a href="{{ route('proposals.sent') }}"
                class="inline-flex items-center justify-center rounded-xl bg-slate-700 hover:bg-slate-600 px-5 py-3 text-sm font-medium text-white transition">
                ← Kembali
            </a>
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

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6 sm:p-8">
            <form action="{{ route('proposals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- PENGIRIM --}}
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
                                    <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                                        {{ $org->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    {{-- TUJUAN --}}
                    <div>
                        <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Destinasi Surat</label>
                        <select name="target_type" id="target_type"
                            class="w-full rounded-2xl border border-slate-700 bg-[#111827] px-5 py-4 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 font-bold">
                            <option value="desa" {{ old('target_type') == 'desa' ? 'selected' : '' }}>Kantor Desa</option>
                            <option value="organization" {{ old('target_type') == 'organization' ? 'selected' : '' }}>Organisasi Lain</option>
                        </select>
                    </div>

                    {{-- ORGANISASI TUJUAN --}}
                    <div id="target_org_wrapper" class="{{ old('target_type') == 'organization' ? '' : 'hidden' }}">
                        <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Pilih Organisasi Tujuan</label>
                        <select name="target_organization_id" id="target_organization_id"
                            class="w-full rounded-2xl border border-slate-700 bg-[#111827] px-5 py-4 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 font-bold disabled:opacity-30">
                            <option value="">-- Pilih Organisasi --</option>
                            @foreach($targetOrganizations as $org)
                                <option value="{{ $org->id }}" {{ old('target_organization_id') == $org->id ? 'selected' : '' }}>
                                    {{ $org->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TANGGAL --}}
                    <div>
                        <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Tanggal Proposal</label>
                        <input type="date" name="proposal_date" value="{{ old('proposal_date', date('Y-m-d')) }}"
                            class="w-full rounded-2xl border border-slate-700 bg-[#111827] px-5 py-4 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition-all font-mono font-bold">
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Judul Proposal / Perihal</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Permohonan Dana Kegiatan HUT RI"
                        class="w-full rounded-2xl border border-slate-700 bg-[#111827] px-5 py-4 text-white placeholder-slate-600 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition-all font-bold">
                </div>

                <div>
                    <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Ringkasan Deskripsi</label>
                    <textarea name="description" rows="6" placeholder="Tuliskan maksud dan tujuan proposal Anda secara singkat..."
                        class="w-full rounded-2xl border border-slate-700 bg-[#111827] px-5 py-4 text-white placeholder-slate-600 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 resize-none transition-all leading-relaxed">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block mb-2 text-xs font-black uppercase tracking-widest text-slate-500 italic">Unggah Dokumen (PDF)</label>
                    <input type="file" name="file" accept="application/pdf"
                        class="w-full rounded-2xl border border-dashed border-slate-600 bg-black/20 p-8 text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:bg-cyan-500 file:text-black hover:file:bg-cyan-400 cursor-pointer transition-all">
                    <p class="mt-2 text-[10px] text-slate-500 font-medium italic">* Maksimal ukuran file: 5MB (Format PDF).</p>
                </div>

                <div class="flex flex-wrap gap-4 pt-8 border-t border-slate-700/50">
                    <button type="submit"
                        class="rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-10 py-4 text-sm font-black uppercase tracking-widest text-white shadow-xl shadow-cyan-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                        Kirim Proposal
                    </button>

                    <a href="{{ route('proposals.sent') }}"
                        class="rounded-2xl bg-slate-800 border border-slate-700 px-10 py-4 text-sm font-black uppercase tracking-widest text-slate-400 hover:bg-slate-700 hover:text-white transition-all">
                        Batalkan
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const targetTypeSelect = document.getElementById('target_type');
        const targetOrgWrapper = document.getElementById('target_org_wrapper');
        const targetOrgSelect = document.getElementById('target_organization_id');

        function toggleTargetOrg() {
            if (targetTypeSelect.value === 'organization') {
                targetOrgWrapper.classList.remove('hidden');
                targetOrgSelect.disabled = false;
            } else {
                targetOrgWrapper.classList.add('hidden');
                targetOrgSelect.disabled = true;
                targetOrgSelect.value = '';
            }
        }

        targetTypeSelect.addEventListener('change', toggleTargetOrg);
        toggleTargetOrg();
    });
</script>
@endpush
sh