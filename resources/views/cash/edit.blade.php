@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-white tracking-wide">Edit Jadwal Kas</h2>
                <p class="text-slate-400 mt-1">Perbarui rincian jadwal iuran kas organisasi.</p>
            </div>

            <a href="{{ route('cash.index') }}"
                class="inline-flex items-center justify-center rounded-xl bg-slate-700 hover:bg-slate-600 px-4 py-2 text-sm font-medium text-white transition">
                ← Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-4 py-4 text-rose-400 shadow-lg">
                <p class="font-semibold mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc ml-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6">
            <form action="{{ route('cash.update', $cash->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Organisasi</label>
                    <select name="organization_id"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                        <option value="">-- Pilih Organisasi --</option>
                        @foreach($organizations as $organization)
                            <option value="{{ $organization->id }}" {{ old('organization_id', $cash->organization_id) == $organization->id ? 'selected' : '' }}>
                                {{ $organization->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Judul Kas</label>
                    <input type="text" name="title" value="{{ old('title', $cash->title) }}" placeholder="Contoh: Kas iuran bulanan"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Jumlah Kas (Rp)</label>
                    <input type="number" name="amount" value="{{ old('amount', $cash->amount) }}" placeholder="Contoh: 50000"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div>
                    <label class="block mb-3 text-sm font-bold text-cyan-400 uppercase tracking-widest italic">Timeline Pembayaran</label>

                    <div id="date-wrapper" class="space-y-3">
                        @php
                            $oldDates = old('dates');
                        @endphp

                        @if($oldDates)
                            @foreach($oldDates as $date)
                                <div class="flex gap-3 group">
                                    <input type="date" name="dates[]" value="{{ $date }}" required
                                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                                    <button type="button" onclick="removeDate(this)"
                                        class="bg-rose-500/10 border border-rose-500/30 text-rose-500 px-4 py-3 rounded-xl hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            @foreach($cash->schedules as $schedule)
                                <div class="flex gap-3 group">
                                    <input type="date" name="dates[]" value="{{ $schedule->due_date?->format('Y-m-d') }}" required
                                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                                    <button type="button" onclick="removeDate(this)"
                                        class="bg-rose-500/10 border border-rose-500/30 text-rose-500 px-4 py-3 rounded-xl hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <button type="button" onclick="addDate()"
                        class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-xl hover:bg-slate-700 transition-all text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        Tambah Tanggal Memberi Iuran
                    </button>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Keterangan</label>
                    <textarea name="description" rows="3" placeholder="Opsional..."
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">{{ old('description', $cash->description) }}</textarea>
                </div>

                <div class="flex flex-wrap gap-3 pt-4">
                    <button type="submit"
                        class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-sm font-bold text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                        Update Jadwal Kas
                    </button>

                    <a href="{{ route('cash.index') }}"
                        class="rounded-xl bg-slate-800 border border-slate-700 px-6 py-3 text-sm font-bold text-slate-300 hover:bg-slate-700 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function addDate() {
        let wrapper = document.getElementById('date-wrapper');
        let row = document.createElement('div');
        row.className = "flex gap-3 group animate-fadeIn";

        row.innerHTML = `
            <input type="date" name="dates[]" required class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
            <button type="button" onclick="removeDate(this)" class="bg-rose-500/10 border border-rose-500/30 text-rose-500 px-4 py-3 rounded-xl hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>
        `;
        wrapper.appendChild(row);
    }

    function removeDate(button) {
        if(document.querySelectorAll('#date-wrapper .flex').length > 1) {
            button.closest('.flex').remove();
        } else {
            alert('Harus ada minimal satu jadwal pembayaran.');
        }
    }
</script>
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn { animation: fadeIn 0.3s ease-out; }
</style>
@endpush