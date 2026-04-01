@extends('layouts.app')

@section('content')

    <div class="max-w-3xl mx-auto space-y-6">

        <div>
            <h2 class="text-3xl font-bold text-white">Tambah Kegiatan</h2>
            <p class="text-slate-400">Buat kegiatan baru untuk organisasi.</p>
        </div>

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6">

            <form action="{{ route('activities.store') }}" method="POST" class="space-y-5">

                @csrf

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Organisasi</label>

                    <select name="organization_id"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">

                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}">
                                {{ $org->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Judul Kegiatan</label>

                    <input type="text" name="title"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Tanggal</label>

                    <input type="date" name="activity_date"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Lokasi</label>

                    <input type="text" name="location"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Deskripsi</label>

                    <textarea name="description" rows="4"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30"></textarea>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Status</label>

                    <select name="status"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">

                        <option value="draft">Draft</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>

                    </select>

                </div>

                <div class="flex gap-3 pt-2">

                    <button
                        class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-2 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                        Simpan
                    </button>

                    <a href="{{ route('activities.index') }}"
                        class="rounded-xl bg-slate-700 px-5 py-2 text-sm text-white hover:bg-slate-600 transition">
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection